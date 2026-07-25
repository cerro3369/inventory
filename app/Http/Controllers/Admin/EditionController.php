<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Edition;
use App\Models\Product;
use Illuminate\Http\Request;

class EditionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.inventario.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $products = Product::orderBy('titulo', 'asc')->get();

        return view('admin.inventario.create', compact('products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id'     => 'required|exists:products,id',
            'numero_edicion' => 'required|string|max:45',
            'precio_compra'  => 'required|numeric|min:0',
            'precio_venta'   => 'required|numeric|min:0',
            'stock_actual'   => 'required|integer|min:0',
        ]);

        // Guardamos en la base de datos
        Edition::create($request->all());

        // Alerta de éxito con SweetAlert2
        session()->flash('swal', [
            'icon'  => 'success',
            'title' => '¡Inventario Recibido!',
            'text'  => 'Nueva Edicion Agregada',
        ]);

        return redirect()->route('admin.inventario.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Edition $edition)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Edition $edition)
    {
        $products = Product::orderBy('titulo', 'asc')->get();

        return view('admin.inventario.edit', compact('edition', 'products'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Edition $edition)
    {
        $request->validate([
            'product_id'     => 'required|exists:products,id',
            'numero_edicion' => 'required|string|max:45',
            'precio_compra'  => 'required|numeric|min:0',
            'precio_venta'   => 'required|numeric|min:0',
            'stock_actual'   => 'required|integer|min:0',
        ]);

        $edition->update($request->all());

        session()->flash('swal', [
            'icon'  => 'success',
            'title' => '¡Actualizado!',
            'text'  => 'La edición se ha modificado correctamente.',
        ]);

        return redirect()->route('admin.inventario.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Edition $edition)
    {
        //
    }
}
