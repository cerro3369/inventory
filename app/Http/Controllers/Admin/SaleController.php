<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Edition;
use App\Models\Sale;
use App\Models\SaleDetail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class SaleController extends Controller
{
    /**
     * Muestra el historial de ventas del comerciante autenticado.
     */
    public function index(): View
    {
        // El Trait BelongsToUser en Sale aplica el Global Scope por usuario automáticamente
        $sales = Sale::with('details.edition.product')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.ventas.index', compact('sales'));
    }

    /**
     * Muestra la pantalla de la caja registradora / POS.
     */
    public function create(): View
    {
        return view('admin.ventas.create');
    }

    /**
     * Procesa y registra una nueva venta HTTP tradicional (fallback a Livewire CajaVenta).
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'items'              => 'required|array|min:1',
            'items.*.edition_id' => 'required|exists:editions,id',
            'items.*.cantidad'   => 'required|integer|min:1',
        ]);

        DB::beginTransaction();

        try {
            // 1. Crear cabecera de la venta (el Trait BelongsToUser asigna el user_id)
            $sale = Sale::create([
                'user_id' => Auth::id(),
                'total'   => 0,
            ]);

            $totalVenta = 0;

            // 2. Procesar cada edición adquirida
            foreach ($request->items as $item) {
                // Verificar que la edición pertenezca a un producto del usuario en sesión
                $edition = Edition::whereHas('product')->findOrFail($item['edition_id']);

                if ($edition->stock_actual < $item['cantidad']) {
                    throw new \Exception("Stock insuficiente para la edición: {$edition->numero_edicion}. Disponible: {$edition->stock_actual} pzas.");
                }

                $subtotal = $edition->precio_venta * $item['cantidad'];
                $totalVenta += $subtotal;

                // 3. Crear renglón del detalle de venta
                SaleDetail::create([
                    'sale_id'         => $sale->id,
                    'edition_id'      => $edition->id,
                    'cantidad'        => $item['cantidad'],
                    'precio_unitario' => $edition->precio_venta,
                ]);

                // 4. Descontar inventario
                $edition->decrement('stock_actual', $item['cantidad']);
            }

            // 5. Actualizar el total definitivo
            $sale->update(['total' => $totalVenta]);

            DB::commit();

            session()->flash('swal', [
                'icon'  => 'success',
                'title' => '¡Venta Realizada!',
                'text'  => "Venta N° {$sale->id} registrada con éxito por $" . number_format($totalVenta, 2),
            ]);

            return redirect()->route('admin.ventas.index');
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }

    /**
     * Muestra el detalle e inspección de una venta realizada.
     */
    public function show(Sale $sale): View
    {
        // El Global Scope de BelongsToUser lanzará 404 si la venta pertenece a otro comerciante
        $sale->load('details.edition.product');

        return view('admin.ventas.show', compact('sale'));
    }

    /**
     * Cancela/Anula una venta devolviendo las unidades al inventario.
     */
    public function destroy(Sale $sale): RedirectResponse
    {
        DB::beginTransaction();

        try {
            // Revertir el stock de cada edición vendida
            foreach ($sale->details as $detail) {
                if ($detail->edition) {
                    $detail->edition->increment('stock_actual', $detail->cantidad);
                }
            }

            // Eliminar detalles y cabecera de la venta
            $sale->details()->delete();
            $sale->delete();

            DB::commit();

            session()->flash('swal', [
                'icon'  => 'success',
                'title' => '¡Venta Anulada!',
                'text'  => 'La venta ha sido cancelada y los productos fueron devueltos al inventario.',
            ]);

            return redirect()->route('admin.ventas.index');
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}