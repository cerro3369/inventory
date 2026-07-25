<x-admin-layout :title="__('Editar Registro de Merma #:id', ['id' => $waste->id])" :breadcrumbs="[
    [
        'name' => __('Dashboard'), 
        'href' => route('admin.dashboard')
    ], 
    [
        'name' => __('Mermas'), 
        'href' => route('admin.mermas.index')
    ], 
    [
        'name' => __('Editar')
    ]
]">
    <div class="max-w-3xl mx-auto">
        <x-wire-card :title="__('Modificar Datos de la Merma')">
            @if($errors->has('error'))
                <div class="mb-4 bg-red-50 text-red-700 p-3 rounded-xl text-sm font-semibold">
                    <i class="fas fa-exclamation-circle mr-2"></i> {{ $errors->first('error') }}
                </div>
            @endif

            <form action="{{ route('admin.mermas.update', $waste) }}" method="POST" class="space-y-4">
                @csrf
                @method('PUT')
                
                <x-wire-input
                    :label="__('Producto / Edición')"
                    value="{{ $waste->edition->product->titulo }} ({{ $waste->edition->numero_edicion }})"
                    disabled
                />

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <x-wire-input 
                        type="number" 
                        :label="__('Cantidad Dañada')" 
                        name="cantidad" 
                        value="{{ old('cantidad', $waste->cantidad) }}" 
                    />
                    
                    <x-wire-select
                        :label="__('Motivo o Tipo de Baja')"
                        name="tipo_baja"
                        :options="[
                            ['label' => __('Maltratado/Roto'), 'value' => 'Maltratado/Roto'],
                            ['label' => __('Mojado'), 'value' => 'Mojado'],
                            ['label' => __('Extraviado/Robo'), 'value' => 'Extraviado/Robo'],
                            ['label' => __('Defecto de fábrica'), 'value' => 'Defecto de fábrica'],
                        ]"
                        option-label="label"
                        option-value="value"
                        :value="old('tipo_baja', $waste->tipo_baja)"
                    />
                </div>

                <x-wire-textarea 
                    :label="__('Notas / Observaciones')" 
                    name="notas" 
                    value="{{ old('notas', $waste->notas) }}" 
                />

                <div class="flex justify-end gap-x-3 pt-2">
                    <x-wire-button href="{{ route('admin.mermas.index') }}" secondary>
                        {{ __('Cancelar') }}
                    </x-wire-button>
                    
                    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-black dark:text-white font-semibold py-2 px-4 rounded-xl shadow-sm focus:outline-none transition">
                        <i class="fas fa-save mr-2"></i> {{ __('Actualizar Registro') }}
                    </button>
                </div>
            </form>
        </x-wire-card>
    </div>
</x-admin-layout>