<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sale;
use App\Models\SaleDetail;
use App\Models\Edition;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Historial de ventas
        $sales = Sale::orderBy('created_at', 'desc')->get();
        return view('admin.ventas.index', compact('sales'));
    }

    public function create()
    {
        // Mostramos la pantalla de la caja registradora
        return view('admin.ventas.create');
    }

    public function store(Request $request)
    {
        // El request idealmente enviará un array de productos seleccionados: 
        // [ ['edition_id' => 1, 'cantidad' => 2], ['edition_id' => 3, 'cantidad' => 1] ]
        $request->validate([
            'items' => 'required|array|min:1',
            'items.*.edition_id' => 'required|exists:editions,id',
            'items.*.cantidad' => 'required|integer|min:1',
        ]);

        // Iniciamos una transacción de base de datos por seguridad
        DB::beginTransaction();

        try {
            // 1. Crear la cabecera de la venta con total inicial de 0
            $sale = Sale::create(['total' => 0]);
            $totalVenta = 0;

            // 2. Procesar cada uno de los productos que se llevan
            foreach ($request->items as $item) {
                $edition = Edition::findOrFail($item['edition_id']);

                // Validamos que haya stock suficiente antes de vender
                if ($edition->stock_actual < $item['cantidad']) {
                    throw new \Exception("Stock insuficiente para la edición: {$edition->numero_edicion}");
                }

                // Calculamos el subtotal de este renglón
                $subtotal = $edition->precio_venta * $item['cantidad'];
                $totalVenta += $subtotal;

                // 3. Crear el registro del detalle de la venta
                SaleDetail::create([
                    'sale_id' => $sale->id,
                    'edition_id' => $edition->id,
                    'cantidad' => $item['cantidad'],
                    'precio_unitario' => $edition->precio_venta
                ]);

                // 4. RESTAR EL STOCK AUTOMÁTICAMENTE 📉
                $edition->decrement('stock_actual', $item['cantidad']);
            }

            // 5. Actualizar el total definitivo de la venta
            $sale->update(['total' => $totalVenta]);

            // Confirmamos que todo salió bien y guardamos en la BD
            DB::commit();

            session()->flash('swal', [
                'icon' => 'success',
                'title' => '¡Venta Realizada!',
                'text' => "Venta registrada con éxito por un total de $$totalVenta",
            ]);

            return redirect()->route('admin.ventas.index');
        } catch (\Exception $e) {
            // Si algo falla, cancelamos todos los cambios hechos en esta transacción
            DB::rollBack();

            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Sale $sale)
    {
        // Cargamos la venta junto con sus renglones y el producto base de cada edición
        $sale->load('details.edition.product');

        return view('admin.ventas.show', compact('sale'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sale $sale)
    {
        return view('admin.ventas.edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Sale $sale)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sale $sale)
    {
        //
    }
}
