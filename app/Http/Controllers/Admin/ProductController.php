<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    /**
     * Muestra el listado de productos base.
     */
    public function index(): View
    {
        return view('admin.catalogo.index');
    }

    /**
     * Muestra el formulario para registrar un nuevo producto base.
     */
    public function create(): View
    {
        return view('admin.catalogo.create');
    }

    /**
     * Guarda el nuevo producto base en la base de datos.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'titulo' => 'required|string|max:255',
        ]);

        // El Trait BelongsToUser asigna el user_id automáticamente
        Product::create($validated);

        session()->flash('swal', [
            'icon'  => 'success',
            'title' => '¡Creado!',
            'text'  => 'El producto base se ha registrado correctamente.',
        ]);

        return redirect()->route('admin.catalogo.index');
    }

    /**
     * Muestra el formulario de edición de un producto base.
     */
    public function edit(Product $product): View
    {
        return view('admin.catalogo.edit', compact('product'));
    }

    /**
     * Actualiza el producto especificado en la base de datos.
     */
    public function update(Request $request, Product $product): RedirectResponse
    {
        $validated = $request->validate([
            'titulo' => 'required|string|max:255',
        ]);

        $product->update($validated);

        session()->flash('swal', [
            'icon'  => 'success',
            'title' => '¡Actualizado!',
            'text'  => 'El producto base se ha actualizado correctamente.',
        ]);

        return redirect()->route('admin.catalogo.index');
    }

    /**
     * Elimina un producto base asegurando que no tenga ediciones activas.
     */
    public function destroy(Product $product): RedirectResponse
    {
        // Validación de integridad: no eliminar si existen ediciones asociadas
        if ($product->editions()->exists()) {
            session()->flash('swal', [
                'icon'  => 'error',
                'title' => 'No se puede eliminar',
                'text'  => 'Este producto tiene ediciones en inventario. Elimina primero las ediciones asociadas.',
            ]);

            return redirect()->route('admin.catalogo.index');
        }

        $product->delete();

        session()->flash('swal', [
            'icon'  => 'success',
            'title' => '¡Eliminado!',
            'text'  => 'El producto base ha sido eliminado.',
        ]);

        return redirect()->route('admin.catalogo.index');
    }
}