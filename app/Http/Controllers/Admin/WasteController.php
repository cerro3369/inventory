<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Edition;
use App\Models\Waste;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class WasteController extends Controller
{
    public function index(): View
    {
        return view('admin.mermas.index');
    }

    public function create(): View
    {
        // Traemos únicamente las ediciones vigentes del usuario que tengan stock disponible
        $editions = Edition::with('product')
            ->whereHas('product')
            ->where('stock_actual', '>', 0)
            ->get();

        return view('admin.mermas.create', compact('editions'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'edition_id' => 'required|exists:editions,id',
            'cantidad'   => 'required|integer|min:1',
            'tipo_baja'  => 'required|string|max:45',
            'notas'      => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            $edition = Edition::whereHas('product')->findOrFail($request->edition_id);

            // Validamos que no intenten dar de baja más de lo existente en almacén
            if ($edition->stock_actual < $request->cantidad) {
                throw new \Exception("No puedes dar de baja una cantidad mayor al stock actual ({$edition->stock_actual} pzas).");
            }

            // 1. Crear registro de la merma (el trait BelongsToUser asigna user_id automáticamente)
            Waste::create($validated);

            // 2. Disminuir stock en almacén
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

    public function edit(Waste $waste): View
    {
        $waste->load('edition.product');
        return view('admin.mermas.edit', compact('waste'));
    }

    public function update(Request $request, Waste $waste): RedirectResponse
    {
        $validated = $request->validate([
            'cantidad'  => 'required|integer|min:1',
            'tipo_baja' => 'required|string|max:45',
            'notas'     => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            $edition = Edition::whereHas('product')->findOrFail($waste->edition_id);
            
            // Calculamos la diferencia entre la nueva cantidad solicitada y la registrada previamente
            $diferencia = $request->cantidad - $waste->cantidad;

            // Si la nueva merma es mayor, descontamos stock adicional
            if ($diferencia > 0) {
                if ($edition->stock_actual < $diferencia) {
                    throw new \Exception("Stock insuficiente en almacén para incrementar la merma.");
                }
                $edition->decrement('stock_actual', $diferencia);
            } 
            // Si la nueva merma es menor, devolvemos las piezas restadas en exceso al inventario
            elseif ($diferencia < 0) {
                $edition->increment('stock_actual', abs($diferencia));
            }

            // Actualizamos la merma
            $waste->update($validated);

            DB::commit();

            session()->flash('swal', [
                'icon'  => 'success',
                'title' => '¡Merma Actualizada!',
                'text'  => 'Los cambios y el inventario fueron recalculados.',
            ]);

            return redirect()->route('admin.mermas.index');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }
}