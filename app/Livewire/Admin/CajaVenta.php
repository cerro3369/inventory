<?php

namespace App\Livewire\Admin;

use App\Models\Edition;
use App\Models\Sale;
use App\Models\SaleDetail;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class CajaVenta extends Component
{
    use WithPagination;

    protected string $paginationTheme = 'tailwind';

    public $search = '';
    public $cart = []; 
    public $total = 0;

    /**
     * Resetea la página cuando se busca algo en el input
     */
    public function updatingSearch()
    {
        $this->resetPage();
    }

    /**
     * Obtiene el catálogo de ediciones filtrado estrictamente por el usuario autenticado (Multi-Tenancy)
     */
    public function getCatalogProperty()
    {
        return Edition::with('product')
            ->whereHas('product') // Aplica el Global Scope del Trait BelongsToUser en Product
            ->where('stock_actual', '>', 0)
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('numero_edicion', 'like', '%' . $this->search . '%')
                        ->orWhereHas('product', function ($pQuery) {
                            $pQuery->where('titulo', 'like', '%' . $this->search . '%');
                        });
                });
            })
            ->orderBy('id', 'desc')
            ->paginate(10);
    }

    public function addToCart($editionId)
    {
        $edition = Edition::with('product')->find($editionId);

        if (!$edition || $edition->stock_actual <= 0) return;

        if (isset($this->cart[$editionId])) {
            if ($this->cart[$editionId]['cantidad'] < $edition->stock_actual) {
                $this->cart[$editionId]['cantidad']++;
            } else {
                $this->dispatch('notify', [
                    'icon'  => 'warning',
                    'title' => 'Stock límite',
                    'text'  => 'No hay más unidades en almacén.'
                ]);
            }
        } else {
            $this->cart[$editionId] = [
                'edition_id' => $edition->id,
                'titulo'     => $edition->product->titulo,
                'numero'     => $edition->numero_edicion,
                'precio'     => $edition->precio_venta,
                'cantidad'   => 1,
                'stock'      => $edition->stock_actual
            ];
        }

        $this->calculateTotal();
    }

    public function updateQuantity($editionId, $quantity)
    {
        if ($quantity <= 0) {
            $this->removeFromCart($editionId);
            return;
        }

        if (isset($this->cart[$editionId])) {
            if ($quantity <= $this->cart[$editionId]['stock']) {
                $this->cart[$editionId]['cantidad'] = $quantity;
            } else {
                $this->cart[$editionId]['cantidad'] = $this->cart[$editionId]['stock'];
                $this->dispatch('notify', [
                    'icon'  => 'warning',
                    'title' => 'Stock superado',
                    'text'  => 'Se ha ajustado a la cantidad máxima disponible.'
                ]);
            }
        }

        $this->calculateTotal();
    }

    public function removeFromCart($editionId)
    {
        unset($this->cart[$editionId]);
        $this->calculateTotal();
    }

    public function calculateTotal()
    {
        $this->total = collect($this->cart)->sum(fn($item) => $item['precio'] * $item['cantidad']);
    }

    public function processSale()
    {
        if (empty($this->cart)) {
            $this->dispatch('notify', [
                'icon'  => 'error', 
                'title' => 'Venta vacía', 
                'text'  => 'Agrega al menos una edición.'
            ]);
            return;
        }

        DB::beginTransaction();

        try {
            // El Trait BelongsToUser asigna automáticamente el user_id de la sesión
            $sale = Sale::create([
                'total' => $this->total
            ]);

            foreach ($this->cart as $item) {
                $edition = Edition::find($item['edition_id']);

                if (!$edition || $edition->stock_actual < $item['cantidad']) {
                    throw new \Exception("La edición '" . ($item['numero'] ?? '') . "' no cuenta con stock suficiente.");
                }

                SaleDetail::create([
                    'sale_id'         => $sale->id,
                    'edition_id'      => $edition->id,
                    'cantidad'        => $item['cantidad'],
                    'precio_unitario' => $item['precio'],
                    'subtotal'        => $item['precio'] * $item['cantidad']
                ]);

                $edition->decrement('stock_actual', $item['cantidad']);
            }

            DB::commit();

            $this->reset(['cart', 'total', 'search']);

            $this->dispatch('swal', [
                'icon'  => 'success',
                'title' => '¡Cobro Exitoso!',
                'text'  => 'La venta se ha registrado y el stock ha sido actualizado.',
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            $this->dispatch('notify', [
                'icon'  => 'error', 
                'title' => 'Error de venta', 
                'text'  => $e->getMessage()
            ]);
        }
    }

    public function render()
    {
        return view('livewire.admin.caja-venta');
    }
}