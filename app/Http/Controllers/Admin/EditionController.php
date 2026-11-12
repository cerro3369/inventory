<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Edition;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class EditionController extends Controller
{
    /**
     * Muestra el listado del inventario de ediciones.
     */
    public function index(): View
    {
        return view('admin.inventario.index');
    }

    /**
     * Muestra el formulario para recepcionar una nueva edición.
     */
    public function create(): View
    {
        // El Trait BelongsToUser en Product filtra automáticamente solo los productos del usuario
        $products = Product::orderBy('titulo', 'asc')->get();

        return view('admin.inventario.create', compact('products'));
    }

    /**
     * Guarda la nueva edición / stock recibido en la base de datos.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'product_id' => [
                'required',
                Rule::exists('products', 'id')->where('user_id', Auth::id()),
            ],
            'numero_edicion' => 'required|string|max:45',
            'precio_compra'  => 'required|numeric|min:0',
            'precio_venta'   => 'required|numeric|min:0',
            'stock_actual'   => 'required|integer|min:0',
        ]);

        Edition::create($validated);

        session()->flash('swal', [
            'icon'  => 'success',
            'title' => '¡Inventario Recibido!',
            'text'  => 'Nueva edición agregada correctamente.',
        ]);

        return redirect()->route('admin.inventario.index');
    }

    /**
     * Muestra el formulario para editar el stock o precios de una edición.
     */
    public function edit(Edition $edition): View
    {
        // Si el producto no pertenece al usuario autenticado (retorna null por el Global Scope)
        if (!$edition->product) {
            abort(403);
        }

        $products = Product::orderBy('titulo', 'asc')->get();

        return view('admin.inventario.edit', compact('edition', 'products'));
    }

    /**
     * Actualiza la información de la edición especificada.
     */
    public function update(Request $request, Edition $edition): RedirectResponse
    {
        if (!$edition->product) {
            abort(403);
        }

        $validated = $request->validate([
            'product_id' => [
                'required',
                Rule::exists('products', 'id')->where('user_id', Auth::id()),
            ],
            'numero_edicion' => 'required|string|max:45',
            'precio_compra'  => 'required|numeric|min:0',
            'precio_venta'   => 'required|numeric|min:0',
            'stock_actual'   => 'required|integer|min:0',
        ]);

        $edition->update($validated);

        session()->flash('swal', [
            'icon'  => 'success',
            'title' => '¡Actualizado!',
            'text'  => 'La edición se ha modificado correctamente.',
        ]);

        return redirect()->route('admin.inventario.index');
    }

    /**
     * Elimina una edición de inventario con validación de integridad referencial.
     */
    public function destroy(Edition $edition): RedirectResponse
    {
        if (!$edition->product) {
            abort(403);
        }

        // Prevenir eliminación si existen ventas o mermas ligadas a esta edición
        if ($edition->saleDetails()->exists() || $edition->wastes()->exists()) {
            session()->flash('swal', [
                'icon'  => 'error',
                'title' => 'No se puede eliminar',
                'text'  => 'Esta edición tiene registros de mermas o ventas asociadas. No se puede borrar para conservar el historial.',
            ]);

            return redirect()->route('admin.inventario.index');
        }

        $edition->delete();

        session()->flash('swal', [
            'icon'  => 'success',
            'title' => '¡Eliminado!',
            'text'  => 'La edición fue eliminada del inventario.',
        ]);

        return redirect()->route('admin.inventario.index');
    }
}