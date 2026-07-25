<x-admin-layout :title="__('Detalle de Venta #:id', ['id' => $sale->id])" :breadcrumbs="[
    [
        'name' => __('Dashboard'),
        'href' => route('admin.dashboard'),
    ],
    [
        'name' => __('Historial de Ventas'),
        'href' => route('admin.ventas.index'),
    ],
    [
        'name' => __('Detalle de Ticket'),
    ],
]">

    <div class="max-w-4xl mx-auto space-y-6">
        
        <div class="flex justify-start">
            <x-wire-button 
                href="{{ route('admin.ventas.index') }}" 
                icon="arrow-left" 
                class="font-semibold shadow-sm"
                secondary
                sm
            >
                <i class="fas fa-arrow-left mr-2"></i> {{ __('Volver al Historial') }}
            </x-wire-button>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            
            <div class="md:col-span-1 space-y-4">
                <x-wire-card :title="__('Resumen del Ticket')">
                    <div class="text-center py-4 border-b border-gray-100 dark:border-secondary-700">
                        <i class="fas fa-receipt text-5xl text-gray-400 dark:text-secondary-500 mb-2"></i>
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">{{ __('Folio de Venta') }}</p>
                        <h3 class="text-2xl font-black text-gray-800 dark:text-gray-100">#{{ $sale->id }}</h3>
                    </div>

                    <div class="py-4 space-y-3 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-500 font-medium">{{ __('Fecha:') }}</span>
                            <span class="font-bold text-gray-900 dark:text-gray-100">
                                {{ $sale->created_at->format('d/m/Y') }}
                            </span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500 font-medium">{{ __('Hora:') }}</span>
                            <span class="font-bold text-gray-900 dark:text-gray-100">
                                {{ $sale->created_at->format('h:i A') }}
                            </span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500 font-medium">{{ __('Artículos:') }}</span>
                            <span class="font-bold text-gray-900 dark:text-gray-100">
                                {{ $sale->details->sum('cantidad') }} {{ __('pzas') }}
                            </span>
                        </div>
                    </div>

                    <div class="mt-2 pt-4 border-t border-gray-200 dark:border-secondary-700 bg-green-50 dark:bg-green-950/30 p-3 rounded-xl text-center">
                        <p class="text-xs font-bold text-green-700 dark:text-green-400 uppercase tracking-wider">{{ __('Total Cobrado') }}</p>
                        <h2 class="text-3xl font-black text-green-600 dark:text-green-400 mt-1">
                            ${{ number_format($sale->total, 2) }}
                        </h2>
                        <span class="text-xs text-green-700 dark:text-green-500 font-medium">MXN</span>
                    </div>
                </x-wire-card>
            </div>

            <div class="md:col-span-2">
                <x-wire-card :title="__('Desglose de Artículos')">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-secondary-700">
                            <thead class="bg-gray-50 dark:bg-secondary-800">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-bold uppercase text-gray-500">{{ __('Producto / Edición') }}</th>
                                    <th class="px-4 py-3 text-center text-xs font-bold uppercase text-gray-500">{{ __('Cantidad') }}</th>
                                    <th class="px-4 py-3 text-right text-xs font-bold uppercase text-gray-500">{{ __('Precio Unitario') }}</th>
                                    <th class="px-4 py-3 text-right text-xs font-bold uppercase text-gray-500">{{ __('Subtotal') }}</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-secondary-700 bg-white dark:bg-secondary-900">
                                @foreach($sale->details as $detail)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-secondary-800 transition">
                                        <td class="px-4 py-4 whitespace-nowrap">
                                            <div class="font-bold text-gray-900 dark:text-gray-100">
                                                {{ $detail->edition->product->titulo }}
                                            </div>
                                            <div class="text-xs text-gray-500 mt-0.5">
                                                {{ __('Edición:') }} {{ $detail->edition->numero_edicion }}
                                            </div>
                                        </td>
                                        <td class="px-4 py-4 whitespace-nowrap text-center text-sm font-semibold text-gray-700 dark:text-gray-300">
                                            {{ $detail->cantidad }}
                                        </td>
                                        <td class="px-4 py-4 whitespace-nowrap text-right text-sm font-medium text-gray-600 dark:text-gray-400">
                                            ${{ number_format($detail->precio_unitario, 2) }}
                                        </td>
                                        <td class="px-4 py-4 whitespace-nowrap text-right text-sm font-bold text-gray-900 dark:text-gray-100">
                                            ${{ number_format($detail->cantidad * $detail->precio_unitario, 2) }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4 flex justify-end items-center gap-x-4 pr-4 py-3 bg-gray-50 dark:bg-secondary-800 rounded-xl">
                        <span class="text-sm font-bold text-gray-500 uppercase">{{ __('Monto Total:') }}</span>
                        <span class="text-xl font-black text-gray-900 dark:text-gray-100">
                            ${{ number_format($sale->total, 2) }} MXN
                        </span>
                    </div>
                </x-wire-card>
            </div>

        </div>

    </div>

</x-admin-layout>