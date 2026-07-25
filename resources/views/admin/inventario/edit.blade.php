<x-admin-layout :title="__('Editar Edición')" :breadcrumbs="[
    [
        'name' => __('Dashboard'),
        'href' => route('admin.dashboard'),
    ],
    [
        'name' => __('Inventario'),
        'href' => route('admin.inventario.index'),
    ],
    [
        'name' => __('Editar Edición'),
    ],
]">
    <x-wire-card>

        <form action="{{ route('admin.inventario.update', $edition) }}" method="POST" class="space-y-4">

            @csrf
            @method('PUT')

            <x-wire-input
                :label="__('Producto Base')"
                name="product_titulo"
                value="{{ $edition->product->titulo }}"
                disabled
            />
            <input type="hidden" name="product_id" value="{{ $edition->product_id }}">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <x-wire-input 
                    :label="__('Número de Edición')" 
                    name="numero_edicion_disabled" 
                    value="{{ $edition->numero_edicion }}" 
                    disabled
                />
                <input type="hidden" name="numero_edicion" value="{{ $edition->numero_edicion }}">

                <x-wire-input 
                    type="number"
                    :label="__('Stock Actual (Cantidad)')" 
                    name="stock_actual" 
                    :placeholder="__('Ej: 10')" 
                    value="{{ old('stock_actual', $edition->stock_actual) }}" 
                />
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <x-wire-input 
                    type="number" 
                    step="0.01" 
                    :label="__('Precio de Compra (Costo)')" 
                    name="precio_compra" 
                    :placeholder="__('Ej: 45.00')" 
                    value="{{ old('precio_compra', $edition->precio_compra) }}" 
                />

                <x-wire-input 
                    type="number" 
                    step="0.01" 
                    :label="__('Precio de Venta al Público')" 
                    name="precio_venta" 
                    :placeholder="__('Ej: 70.00')" 
                    value="{{ old('precio_venta', $edition->precio_venta) }}" 
                />
            </div>

            <div class="flex justify-end pt-2">
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-black dark:text-white font-semibold py-2 px-4 rounded-xl shadow-sm focus:outline-none transition">
                    <i class="fas fa-save mr-2"></i> {{ __('Actualizar') }}
                </button>
            </div>

        </form>

    </x-wire-card>
</x-admin-layout>