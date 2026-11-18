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

            if ($edition->stock_actual < $request->cantidad) {
                throw new \Exception("No puedes dar de baja una cantidad mayor al stock actual ({$edition->stock_actual} pzas).");
            }

            Waste::create($validated);

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
            
            $diferencia = $request->cantidad - $waste->cantidad;

            if ($diferencia > 0) {
                if ($edition->stock_actual < $diferencia) {
                    throw new \Exception("Stock insuficiente en almacén para incrementar la merma.");
                }
                $edition->decrement('stock_actual', $diferencia);
            } 
            elseif ($diferencia < 0) {
                $edition->increment('stock_actual', abs($diferencia));
            }

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