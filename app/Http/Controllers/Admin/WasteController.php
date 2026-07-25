<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Waste;
use App\Models\Edition;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WasteController extends Controller
{
    public function index()
    {
        return view('admin.mermas.index');
    }

    public function create()
    {
        // Traemos las ediciones vigentes que tengan stock para poder darlas de baja
        $editions = Edition::with('product')->where('stock_actual', '>', 0)->get();
        return view('admin.mermas.create', compact('editions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'edition_id' => 'required|exists:editions,id',
            'cantidad'   => 'required|integer|min:1',
            'tipo_baja'  => 'required|string|max:45',
            'notas'      => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            $edition = Edition::findOrFail($request->edition_id);

            // Validamos que no intenten dar de baja más de lo que hay físico
            if ($edition->stock_actual < $request->cantidad) {
                throw new \Exception("No puedes dar de baja una cantidad mayor al stock actual ({$edition->stock_actual} pzas).");
            }

            // 1. Crear registro de la merma
            Waste::create($request->all());

            // 2. DISMINUIR STOCK 📉
            $edition->decrement('stock_actual', $request->cantidad);

            DB::commit();

            session()->flash('swal', [
                'icon'  => 'success',
                'title' => '¡Merma Registrada!',
                'text'  => 'La baja de inventario se aplicó correctamente.',
            ]);

            return redirect()->route('admin.mermas.index');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }

    public function edit(Waste $waste)
    {
        $waste->load('edition.product');
        return view('admin.mermas.edit', compact('waste'));
    }

    public function update(Request $request, Waste $waste)
    {
        $request->validate([
            'cantidad'  => 'required|integer|min:1',
            'tipo_baja' => 'required|string|max:45',
            'notas'     => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            $edition = Edition::findOrFail($waste->edition_id);
            
            // Calculamos la diferencia entre la cantidad vieja de la merma y la nueva
            $diferencia = $request->cantidad - $waste->cantidad;

            // Si la nueva cantidad de merma es mayor, restamos más stock
            if ($diferencia > 0) {
                if ($edition->stock_actual < $diferencia) {
                    throw new \Exception("Stock insuficiente en almacén para incrementar la merma.");
                }
                $edition->decrement('stock_actual', $diferencia);
            } 
            // Si la nueva cantidad de merma es menor, devolvemos stock al inventario
            elseif ($diferencia < 0) {
                $edition->increment('stock_actual', abs($diferencia));
            }

            // Actualizamos los datos
            $waste->update($request->only(['cantidad', 'tipo_baja', 'notas']));

            DB::commit();

            session()->flash('swal', [
                'icon'  => 'success',
                'title' => '¡Merma Actualizada!',
                'text'  => 'Los cambios y el inventario fueron recalculados.',
            ]);

            return redirect()->route('admin.mermas.index');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}