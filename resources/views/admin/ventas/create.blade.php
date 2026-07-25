<x-admin-layout :title="__('Caja Registradora')" :breadcrumbs="[
    [
        'name' => __('Dashboard'),
        'href' => route('admin.dashboard'),
    ],
    [
        'name' => __('Ventas'),
        'href' => route('admin.ventas.index'),
    ],
    [
        'name' => __('Nueva Venta / Caja'),
    ],
]">

    <livewire:admin.caja-venta />

</x-admin-layout>