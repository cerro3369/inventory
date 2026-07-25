<x-admin-layout :title="__('Productos')" :breadcrumbs="[
    [
        'name' => __('Dashboard'),
        'href' => route('admin.dashboard'),
    ],
    [
        'name' => __('Productos'),
        'href' => route('admin.catalogo.index'),
    ],
    [
        'name' => __('Producto nuevo'),
    ],
]">
    <x-wire-card>

        <form action="{{ route('admin.catalogo.store') }}" method="POST" class="space-y-4">

            @csrf

            <x-wire-input 
                :label="__('Título')" 
                name="titulo" 
                :placeholder="__('Título del Producto')" 
                value="{{ old('titulo') }}" />

            <div class="flex justify-end">

                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-black dark:text-white font-semibold py-2 px-4 rounded-xl shadow-sm focus:outline-none transition">
                    <i class="fas fa-save mr-2"></i> {{ __('Guardar') }}
                </button>

            </div>

        </form>

    </x-wire-card>

</x-admin-layout>