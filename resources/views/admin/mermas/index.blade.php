<x-admin-layout :title="__('Control de Mermas')" :breadcrumbs="[
    [
        'name' => __('Dashboard'), 
        'href' => route('admin.dashboard')
    ], 
    [
        'name' => __('Mermas')
    ]
]">
    <div class="space-y-4">
        <div class="flex justify-end">
            <a href="{{ route('admin.mermas.create') }}" class="bg-blue-500 hover:bg-blue-600 text-black dark:text-white font-semibold py-2 px-4 rounded-xl shadow-sm focus:outline-none transition">
                <i class="fas fa-plus mr-2"></i> {{ __('Registrar Nueva Merma') }}
            </a>
        </div>
        <x-wire-card>
            <livewire:admin.datatable.waste-table />
        </x-wire-card>
    </div>
</x-admin-layout>