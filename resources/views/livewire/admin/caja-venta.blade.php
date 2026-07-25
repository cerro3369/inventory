<div class="space-y-6">

    {{-- Buscador y Catálogo de Productos --}}
    <div class="space-y-4">
        
        <x-wire-input 
            wire:model.live.debounce.300ms="search"
            :placeholder="__('Filtrar por título o edición...')" 
            class="py-2.5 text-base shadow-sm"
        >
            <x-slot name="prepend">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="text-gray-400"></i>
                </div>
            </x-slot>
        </x-wire-input>

        <x-wire-card :title="__('Catálogo de Productos')">
            <div class="overflow-x-auto">
                <table class="w-full divide-y divide-gray-200 dark:divide-secondary-700">
                    <thead class="bg-gray-50 dark:bg-secondary-800">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider text-gray-500">{{ __('Título') }}</th>
                            <th class="px-6 py-3 text-center text-xs font-bold uppercase tracking-wider text-gray-500">{{ __('Edición') }}</th>
                            <th class="px-6 py-3 text-center text-xs font-bold uppercase tracking-wider text-gray-500">{{ __('Precio') }}</th>
                            <th class="px-6 py-3 text-center text-xs font-bold uppercase tracking-wider text-gray-500">{{ __('Stock') }}</th>
                            <th class="px-6 py-3 text-center text-xs font-bold uppercase tracking-wider text-gray-500">{{ __('Acción') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-secondary-700 bg-white dark:bg-secondary-900">
                        @forelse($this->catalog as $edition)
                            <tr class="hover:bg-gray-50 dark:hover:bg-secondary-800 transition">
                                <td class="px-6 py-4 font-semibold text-gray-900 dark:text-gray-100">
                                    {{ $edition->product->titulo }}
                                </td>
                                <td class="px-6 py-4 text-center text-sm text-gray-500 whitespace-nowrap">
                                    {{ $edition->numero_edicion }}
                                </td>
                                <td class="px-6 py-4 text-center font-bold text-blue-600 dark:text-blue-400 whitespace-nowrap">
                                    ${{ number_format($edition->precio_venta, 2) }}
                                </td>
                                <td class="px-6 py-4 text-center whitespace-nowrap">
                                    <span class="px-3 py-1 rounded-full text-xs font-bold 
                                        {{ $edition->stock_actual <= 3 ? 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' : 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' }}">
                                        {{ $edition->stock_actual }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center whitespace-nowrap">
                                    <x-wire-button 
                                        wire:click="addToCart({{ $edition->id }})"
                                        blue 
                                        sm 
                                        class="font-semibold shadow-sm"
                                    >
                                        {{ __('Agregar') }}
                                    </x-wire-button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-8 text-center text-gray-400">
                                    {{ __('No hay productos disponibles en el catálogo.') }}
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Paginación (10 en 10) --}}
            @if(method_exists($this->catalog, 'links'))
                <div class="mt-4 px-4">
                    {{ $this->catalog->links() }}
                </div>
            @endif
        </x-wire-card>
    </div>

    {{-- Venta Actual / Carrito (Ubicado Abajo) --}}
    <div>
        <x-wire-card :title="__('Venta Actual')">
            <div class="space-y-4">
                
                <div class="divide-y divide-gray-200 dark:divide-secondary-700 max-h-96 overflow-y-auto pr-1">
                    @forelse($cart as $id => $item)
                        <div class="py-3 flex justify-between items-center">
                            <div class="flex-1">
                                <h4 class="font-bold text-sm text-gray-900 dark:text-gray-100">
                                    {{ $item['titulo'] }} ({{ $item['numero'] }})
                                </h4>
                                <p class="text-xs text-gray-500">
                                    {{ $item['cantidad'] }} {{ $item['cantidad'] > 1 ? __('Unidades') : __('Unidad') }} x ${{ number_format($item['precio'], 2) }}
                                </p>
                            </div>

                            <div class="flex items-center gap-x-2">
                                <input 
                                    type="number" 
                                    value="{{ $item['cantidad'] }}" 
                                    wire:change="updateQuantity({{ $id }}, $event.target.value)"
                                    class="w-16 text-center border-gray-300 dark:border-secondary-700 rounded-lg text-sm"
                                    min="1"
                                    max="{{ $item['stock'] }}"
                                >
                                <x-wire-button 
                                    flat 
                                    negative 
                                    xs 
                                    wire:click="removeFromCart({{ $id }})" 
                                >
                                    <i class="fas fa-trash"></i>
                                </x-wire-button>
                            </div>
                        </div>
                    @empty
                        <div class="py-12 text-center text-gray-400">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            <p class="mt-2 text-sm">{{ __('Caja vacía. Selecciona productos de la lista.') }}</p>
                        </div>
                    @endforelse
                </div>

                @if(!empty($cart))
                    <div class="border-t border-gray-200 dark:border-secondary-700 pt-4 space-y-3">
                        <div class="flex flex-col items-center bg-gray-50 dark:bg-secondary-800 p-4 rounded-xl border border-gray-100 dark:border-secondary-700">
                            <span class="text-gray-500 dark:text-gray-400 text-sm font-semibold uppercase tracking-wider">{{ __('Total a pagar') }}</span>
                            <span class="text-3xl font-black text-green-600 dark:text-green-400 mt-1">
                                ${{ number_format($total, 2) }} MXN
                            </span>
                        </div>

                        <div class="pt-2">
                            <button 
                                wire:click="processSale" 
                                wire:loading.attr="disabled"
                                class="w-full text-lg py-3 font-bold bg-custom-primary text-white rounded-xl shadow-sm inline-flex items-center justify-center hover:opacity-90 transition disabled:opacity-50"
                            >
                                <span wire:loading.remove wire:target="processSale">
                                    <i class="fas fa-check-circle mr-2"></i> {{ __('Registrar Venta') }}
                                </span>
                                <span wire:loading wire:target="processSale" class="inline-flex items-center">
                                    <i class="fas fa-spinner fa-spin mr-2"></i> {{ __('Procesando...') }}
                                </span>
                            </button>
                        </div>
                    </div>
                @endif

            </div>
        </x-wire-card>
    </div>

</div>

@script
<script>
    $wire.on('notify', (data) => {
        window.$wireui.notify({
            icon: data[0].icon,
            title: data[0].title,
            description: data[0].text,
        });
    });
    
    $wire.on('swal', (data) => {
        Swal.fire({
            icon: data[0].icon,
            title: data[0].title,
            text: data[0].text,
            timer: 3000
        });
    });
</script>
@endscript