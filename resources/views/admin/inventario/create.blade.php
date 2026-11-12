<x-admin-layout :title="__('Recepción de Inventario')" :breadcrumbs="[
    [
        'name' => __('Dashboard'),
        'href' => route('admin.dashboard'),
    ],
    [
        'name' => __('Inventario'),
        'href' => route('admin.inventario.index'),
    ],
    [
        'name' => __('Nueva Edición / Recepción'),
    ],
]">
    <x-wire-card>
        <form action="{{ route('admin.inventario.store') }}" method="POST" class="space-y-4">
            @csrf

            <x-wire-native-select 
                :label="__('Seleccionar Producto Base')" 
                name="product_id"
            >
                <option value="">{{ __('Busca o selecciona un producto...') }}</option>
                @foreach ($products as $product)
                    <option value="{{ $product->id }}" @selected(old('product_id') == $product->id)>
                        {{ $product->titulo }}
                    </option>
                @endforeach
            </x-wire-native-select>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <x-wire-input 
                    :label="__('Número de Edición')" 
                    name="numero_edicion" 
                    :placeholder="__('Ej: N° 12, Tomo 3, Especial Verano')"
                    value="{{ old('numero_edicion') }}" 
                />

                <x-wire-input 
                    type="number" 
                    :label="__('Stock Inicial (Cantidad)')" 
                    name="stock_actual" 
                    :placeholder="__('Ej: 10')"
                    value="{{ old('stock_actual') }}" 
                />
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <x-wire-input 
                    type="number" 
                    step="0.01" 
                    :label="__('Precio de Compra (Costo)')" 
                    name="precio_compra" 
                    :placeholder="__('Ej: 45.00')"
                    value="{{ old('precio_compra') }}" 
                />

                <x-wire-input 
                    type="number" 
                    step="0.01" 
                    :label="__('Precio de Venta al Público')" 
                    name="precio_venta" 
                    :placeholder="__('Ej: 70.00')"
                    value="{{ old('precio_venta') }}" 
                />
            </div>

            <div class="flex justify-end pt-2">
                <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-xl shadow-sm focus:outline-none transition inline-flex items-center">
                    <i class="fas fa-save mr-2"></i> {{ __('Registrar Recepción') }}
                </button>
            </div>
        </form>
    </x-wire-card>
</x-admin-layout>