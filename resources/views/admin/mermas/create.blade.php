<x-admin-layout :title="__('Registrar Merma / Baja')" :breadcrumbs="[
    [
        'name' => __('Dashboard'), 
        'href' => route('admin.dashboard')
    ], 
    [
        'name' => __('Mermas'), 
        'href' => route('admin.mermas.index')
    ], 
    [
        'name' => __('Registrar')
    ]
]">
    <div class="max-w-3xl mx-auto">
        <x-wire-card :title="__('Detalles de la Baja de Inventario')">
            @if($errors->has('error'))
                <div class="mb-4 bg-red-50 text-red-700 p-3 rounded-xl text-sm font-semibold">
                    <i class="fas fa-exclamation-circle mr-2"></i> {{ $errors->first('error') }}
                </div>
            @endif

            <form action="{{ route('admin.mermas.store') }}" method="POST" class="space-y-4">
                @csrf
                
                <x-wire-select
                    :label="__('Seleccionar Producto / Edición Maltratada')"
                    :placeholder="__('Busca la edición...')"
                    name="edition_id"
                    :options="$editions"
                    option-label="numero_edicion"
                    option-value="id"
                    :value="old('edition_id')"
                />

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <x-wire-input 
                        type="number" 
                        :label="__('Cantidad Dañada')" 
                        name="cantidad" 
                        value="{{ old('cantidad') }}" 
                        :placeholder="__('Ej: 2')" 
                    />
                    
                    <x-wire-select
                        :label="__('Motivo o Tipo de Baja')"
                        :placeholder="__('Selecciona el motivo...')"
                        name="tipo_baja"
                        :options="[
                            ['label' => __('Maltratado/Roto'), 'value' => 'Maltratado/Roto'],
                            ['label' => __('Mojado'), 'value' => 'Mojado'],
                            ['label' => __('Extraviado/Robo'), 'value' => 'Extraviado/Robo'],
                            ['label' => __('Defecto de fábrica'), 'value' => 'Defecto de fábrica'],
                        ]"
                        option-label="label"
                        option-value="value"
                        :value="old('tipo_baja')"
                    />
                </div>

                <x-wire-textarea 
                    :label="__('Notas / Observaciones adicionales')" 
                    name="notas" 
                    :placeholder="__('Escribe detalles de lo sucedido...')" 
                    value="{{ old('notas') }}" 
                />

                <div class="flex justify-end gap-x-3 pt-2">
                    <x-wire-button href="{{ route('admin.mermas.index') }}" secondary>
                        {{ __('Cancelar') }}
                    </x-wire-button>

                    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-black dark:text-white font-semibold py-2 px-4 rounded-xl shadow-sm focus:outline-none transition">
                        <i class="fas fa-check mr-2"></i> {{ __('Confirmar Baja') }}
                    </button>
                </div>
            </form>
        </x-wire-card>
    </div>
</x-admin-layout>