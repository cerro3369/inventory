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
                <div class="mb-4 bg-red-50 dark:bg-red-950/50 text-red-700 dark:text-red-300 p-3 rounded-xl text-sm font-semibold border border-red-200 dark:border-red-900">
                    <i class="fas fa-exclamation-circle mr-2"></i> {{ $errors->first('error') }}
                </div>
            @endif

            <form action="{{ route('admin.mermas.store') }}" method="POST" class="space-y-4">
                @csrf
                
                <x-wire-native-select
                    :label="__('Seleccionar Producto / Edición Maltratada')"
                    name="edition_id"
                >
                    <option value="">{{ __('Busca la edición...') }}</option>
                    @foreach($editions as $edition)
                        <option value="{{ $edition->id }}" @selected(old('edition_id') == $edition->id)>
                            {{ $edition->product->titulo }} - Edición: {{ $edition->numero_edicion }} (Stock: {{ $edition->stock_actual }} pzas)
                        </option>
                    @endforeach
                </x-wire-native-select>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <x-wire-input 
                        type="number" 
                        :label="__('Cantidad Dañada')" 
                        name="cantidad" 
                        value="{{ old('cantidad') }}" 
                        :placeholder="__('Ej: 2')" 
                        min="1"
                    />
                    
                    <x-wire-native-select
                        :label="__('Motivo o Tipo de Baja')"
                        name="tipo_baja"
                    >
                        <option value="">{{ __('Selecciona el motivo...') }}</option>
                        <option value="Maltratado/Roto" @selected(old('tipo_baja') == 'Maltratado/Roto')>{{ __('Maltratado/Roto') }}</option>
                        <option value="Mojado" @selected(old('tipo_baja') == 'Mojado')>{{ __('Mojado') }}</option>
                        <option value="Extraviado/Robo" @selected(old('tipo_baja') == 'Extraviado/Robo')>{{ __('Extraviado/Robo') }}</option>
                        <option value="Defecto de fábrica" @selected(old('tipo_baja') == 'Defecto de fábrica')>{{ __('Defecto de fábrica') }}</option>
                    </x-wire-native-select>
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

                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-xl shadow-sm focus:outline-none transition inline-flex items-center">
                        <i class="fas fa-check mr-2"></i> {{ __('Confirmar Baja') }}
                    </button>
                </div>
            </form>
        </x-wire-card>
    </div>
</x-admin-layout>