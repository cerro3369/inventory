<div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">

    {{-- Izquierda --}}
    <div class="lg:col-span-7 space-y-4">
        
        {{-- Buscador --}}
        <div class="relative">
            <x-wire-input 
                wire:model.live.debounce.300ms="search"
                :placeholder="__('Buscar por título, cómic, manga o número de edición...')" 
                class="py-3 text-base shadow-sm focus:ring-2 focus:ring-blue-500 pl-10"
                autofocus
            >
                
            </x-wire-input>
        </div>

        {{-- Catálogo de Productos --}}
        <x-wire-card class="shadow-md">
            <div class="flex items-center justify-between pb-3 border-b border-gray-100 dark:border-secondary-700">
                <h3 class="font-bold text-gray-800 dark:text-gray-100 flex items-center gap-2">
                    <i class="fas fa-boxes text-blue-500"></i> {{ __('Catálogo Disponible') }}
                </h3>
                @if($search)
                    <span class="text-xs font-medium text-blue-600 dark:text-blue-400 bg-blue-50 dark:bg-blue-950/50 px-2.5 py-1 rounded-full border border-blue-200 dark:border-blue-800">
                        {{ __('Filtrando:') }} "{{ $search }}"
                    </span>
                @endif
            </div>

            <div class="overflow-x-auto mt-3">
                <table class="w-full divide-y divide-gray-200 dark:divide-secondary-700 text-sm">
                    <thead class="bg-gray-50 dark:bg-secondary-800">
                        <tr>
                            <th class="px-4 py-3 text-left font-bold uppercase tracking-wider text-xs text-gray-500">{{ __('Título / Producto') }}</th>
                            <th class="px-3 py-3 text-center font-bold uppercase tracking-wider text-xs text-gray-500">{{ __('Edición') }}</th>
                            <th class="px-3 py-3 text-center font-bold uppercase tracking-wider text-xs text-gray-500">{{ __('Precio') }}</th>
                            <th class="px-3 py-3 text-center font-bold uppercase tracking-wider text-xs text-gray-500">{{ __('Stock') }}</th>
                            <th class="px-3 py-3 text-center font-bold uppercase tracking-wider text-xs text-gray-500">{{ __('Acción') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-secondary-700 bg-white dark:bg-secondary-900">
                        @forelse($this->catalog as $edition)
                            <tr class="hover:bg-blue-50/50 dark:hover:bg-secondary-800/60 transition">
                                <td class="px-4 py-3 font-semibold text-gray-900 dark:text-gray-100">
                                    {{ $edition->product->titulo }}
                                </td>
                                <td class="px-3 py-3 text-center text-gray-600 dark:text-gray-400 whitespace-nowrap">
                                    <span class="bg-gray-100 dark:bg-secondary-800 px-2 py-0.5 rounded text-xs font-mono">
                                        {{ $edition->numero_edicion }}
                                    </span>
                                </td>
                                <td class="px-3 py-3 text-center font-bold text-blue-600 dark:text-blue-400 whitespace-nowrap">
                                    ${{ number_format($edition->precio_venta, 2) }}
                                </td>
                                <td class="px-3 py-3 text-center whitespace-nowrap">
                                    <span class="px-2.5 py-1 rounded-full text-xs font-bold inline-flex items-center gap-1
                                        {{ $edition->stock_actual <= 3 ? 'bg-red-100 text-red-800 dark:bg-red-950 dark:text-red-300 border border-red-200 dark:border-red-900' : 'bg-green-100 text-green-800 dark:bg-green-950 dark:text-green-300 border border-green-200 dark:border-green-900' }}">
                                        @if($edition->stock_actual <= 3)
                                            <i class="fas fa-exclamation-triangle text-[10px]"></i>
                                        @endif
                                        {{ $edition->stock_actual }}
                                    </span>
                                </td>
                                <td class="px-3 py-3 text-center whitespace-nowrap">
                                    <x-wire-button 
                                        wire:click="addToCart({{ $edition->id }})"
                                        blue 
                                        xs 
                                        class="font-semibold shadow-sm hover:scale-105 transition-transform"
                                    >
                                        <i class="fas fa-plus mr-1"></i> {{ __('Agregar') }}
                                    </x-wire-button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-10 text-center text-gray-400">
                                    <i class="fas fa-search-minus text-3xl mb-2 text-gray-300 dark:text-gray-600"></i>
                                    <p class="text-sm font-medium">{{ __('No se encontraron productos coincidentes.') }}</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if(method_exists($this->catalog, 'links'))
                <div class="mt-4 pt-3 border-t border-gray-100 dark:border-secondary-800">
                    {{ $this->catalog->links() }}
                </div>
            @endif
        </x-wire-card>
    </div>

    {{-- Derecha --}}
    <div class="lg:col-span-5 lg:sticky lg:top-4 space-y-4">
        <x-wire-card class="shadow-lg border-t-4 border-t-blue-500">
            <div class="flex items-center justify-between pb-3 border-b border-gray-100 dark:border-secondary-700">
                <h3 class="font-bold text-gray-900 dark:text-gray-100 flex items-center gap-2">
                    <i class="fas fa-shopping-cart text-blue-500"></i> {{ __('Venta Actual') }}
                </h3>
                @if(!empty($cart))
                    <span class="text-xs font-semibold bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200 px-2 py-0.5 rounded-full">
                        {{ count($cart) }} {{ count($cart) === 1 ? __('ítem') : __('ítems') }}
                    </span>
                @endif
            </div>

            <div class="mt-3 space-y-3">
                {{-- Lista de productos --}}
                <div class="divide-y divide-gray-100 dark:divide-secondary-800 max-h-[380px] overflow-y-auto pr-1">
                    @forelse($cart as $id => $item)
                        <div class="py-3 flex items-center justify-between gap-2">
                            <div class="flex-1 min-w-0">
                                <h4 class="font-bold text-sm text-gray-900 dark:text-gray-100 truncate">
                                    {{ $item['titulo'] }}
                                </h4>
                                <div class="flex items-center gap-2 text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                                    <span class="bg-gray-100 dark:bg-secondary-800 px-1.5 py-0.5 rounded font-mono">
                                        {{ $item['numero'] }}
                                    </span>
                                    <span>${{ number_format($item['precio'], 2) }} c/u</span>
                                </div>
                            </div>

                            <div class="flex items-center gap-1">
                                <button 
                                    type="button"
                                    wire:click="updateQuantity({{ $id }}, {{ $item['cantidad'] - 1 }})"
                                    class="w-7 h-7 flex items-center justify-center bg-gray-100 hover:bg-gray-200 dark:bg-secondary-800 dark:hover:bg-secondary-700 text-gray-700 dark:text-gray-200 rounded-lg text-xs font-bold transition disabled:opacity-30"
                                    @disabled($item['cantidad'] <= 1)
                                >
                                    <i class="fas fa-minus"></i>
                                </button>

                                <span class="w-8 text-center font-bold text-sm text-gray-900 dark:text-gray-100">
                                    {{ $item['cantidad'] }}
                                </span>

                                <button 
                                    type="button"
                                    wire:click="updateQuantity({{ $id }}, {{ $item['cantidad'] + 1 }})"
                                    class="w-7 h-7 flex items-center justify-center bg-gray-100 hover:bg-gray-200 dark:bg-secondary-800 dark:hover:bg-secondary-700 text-gray-700 dark:text-gray-200 rounded-lg text-xs font-bold transition disabled:opacity-30"
                                    @disabled($item['cantidad'] >= $item['stock'])
                                >
                                    <i class="fas fa-plus"></i>
                                </button>

                                <x-wire-button 
                                    flat 
                                    negative 
                                    xs 
                                    icon="trash"
                                    wire:click="removeFromCart({{ $id }})" 
                                    class="ml-1"
                                />
                            </div>
                        </div>
                    @empty
                        <div class="py-12 text-center text-gray-400">
                            <i class="fas fa-cash-register text-4xl mb-3 text-gray-300 dark:text-gray-600"></i>
                            <p class="text-sm font-medium">{{ __('Caja vacía.') }}</p>
                            <p class="text-xs text-gray-400 mt-1">{{ __('Haz clic en "Agregar" en cualquier producto para iniciar el ticket.') }}</p>
                        </div>
                    @endforelse
                </div>

                {{-- Resumen --}}
                @if(!empty($cart))
                    <div class="border-t border-gray-200 dark:border-secondary-700 pt-4 space-y-3">
                        <div class="flex flex-col items-center justify-center bg-green-50 dark:bg-green-950/40 p-4 rounded-xl border border-green-200 dark:border-green-900/60">
                            <span class="text-green-800 dark:text-green-300 text-xs font-bold uppercase tracking-wider">{{ __('Total a cobrar') }}</span>
                            <span class="text-3xl font-black text-green-600 dark:text-green-400 mt-1">
                                ${{ number_format($total, 2) }} <span class="text-xs font-normal">MXN</span>
                            </span>
                        </div>

                        <div>
                            <button 
                                type="button"
                                wire:click="processSale" 
                                wire:loading.attr="disabled"
                                class="w-full text-base py-3.5 font-bold bg-green-600 hover:bg-green-700 active:bg-green-800 text-white rounded-xl shadow-md inline-flex items-center justify-center transition disabled:opacity-50"
                            >
                                <span wire:loading.remove wire:target="processSale" class="inline-flex items-center">
                                    <i class="fas fa-check-circle mr-2 text-lg"></i> {{ __('Completar y Registrar Venta') }}
                                </span>
                                <span wire:loading wire:target="processSale" class="inline-flex items-center">
                                    <i class="fas fa-circle-notch fa-spin mr-2 text-lg"></i> {{ __('Procesando Venta...') }}
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