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

    public function index(): View
    {
        $sales = Sale::with('details.edition.product')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.ventas.index', compact('sales'));
    }

    public function create(): View
    {
        return view('admin.ventas.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'items'              => 'required|array|min:1',
            'items.*.edition_id' => 'required|exists:editions,id',
            'items.*.cantidad'   => 'required|integer|min:1',
        ]);

        DB::beginTransaction();

        try {
            $sale = Sale::create([
                'user_id' => Auth::id(),
                'total'   => 0,
            ]);

            $totalVenta = 0;

            foreach ($request->items as $item) {
                $edition = Edition::whereHas('product')->findOrFail($item['edition_id']);

                if ($edition->stock_actual < $item['cantidad']) {
                    throw new \Exception("Stock insuficiente para la edición: {$edition->numero_edicion}. Disponible: {$edition->stock_actual} pzas.");
                }

                $subtotal = $edition->precio_venta * $item['cantidad'];
                $totalVenta += $subtotal;

                SaleDetail::create([
                    'sale_id'         => $sale->id,
                    'edition_id'      => $edition->id,
                    'cantidad'        => $item['cantidad'],
                    'precio_unitario' => $edition->precio_venta,
                ]);

                $edition->decrement('stock_actual', $item['cantidad']);
            }

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

    public function show(Sale $sale): View
    {
        $sale->load('details.edition.product');

        return view('admin.ventas.show', compact('sale'));
    }

    public function destroy(Sale $sale): RedirectResponse
    {
        DB::beginTransaction();

        try {
            foreach ($sale->details as $detail) {
                if ($detail->edition) {
                    $detail->edition->increment('stock_actual', $detail->cantidad);
                }
            }

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