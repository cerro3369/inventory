<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.catalogo.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.catalogo.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
        ]);

        Product::create($request->all());

        session()->flash('swal', [
            'icon' => 'success',
            'title' => '¡Creado!',
            'text' => 'Producto creado corretamente!!!',
        ]);

        return redirect()->route('admin.catalogo.index')->with('success', '¡Producto registrado con éxito!');
    }

    /**
     * Display the specified resource.
     */
    // public function show(Product $product)
    // {
    //     //
    // }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        return view('admin.catalogo.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
        'titulo' => 'required|string|max:255',
    ]);

    $product->update($request->all());

    session()->flash('swal', [
        'icon' => 'success',
        'title' => '¡Actualizado!',
        'text' => 'Producto actualizado correctamente!!!',
    ]);

    return redirect()->route('admin.catalogo.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    // public function destroy(Product $product)
    // {
    //     //
    // }
}
