<x-admin-layout 
    :title="__('Productos')"
    :breadcrumbs="[
        [
            'name' => __('Dashboard'),
            'href' => route('admin.dashboard'),
        ],
        [
            'name' => __('Productos'),
        ],
    ]">

    <x-slot name="action">
        <a href="{{ route('admin.catalogo.create') }}" class="bg-blue-500 hover:bg-blue-600 text-black dark:text-white font-semibold py-2 px-4 rounded-xl shadow-sm focus:outline-none transition">
            <i class="fas fa-plus mr-2"></i> {{ __('Nuevo producto') }}
        </a>
    </x-slot>

    <livewire:admin.datatable.product-table/>

</x-admin-layout>