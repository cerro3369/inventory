<x-admin-layout :title="__('Panel de Control / Balance Financiero')" :breadcrumbs="[
    ['name' => __('Dashboard')],
]">

    <div class="space-y-6">
        <div>
            <p class="text-sm text-gray-500 dark:text-slate-400">{{ __('Aquí tienes el estado financiero actual.') }}</p>
        </div>

        {{-- Tarjetas Financieras --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            
            <!-- Tarjeta de Ingresos -->
            <div class="bg-white dark:bg-slate-900 rounded-2xl p-6 border border-gray-100 dark:border-slate-800 shadow-sm flex items-center justify-between transition-colors">
                <div class="space-y-2">
                    <p class="text-xs font-bold text-gray-400 dark:text-slate-400 uppercase tracking-wider">{{ __('Ingresos (Ventas)') }}</p>
                    <h3 class="text-3xl font-black text-emerald-600 dark:text-emerald-400">
                        ${{ number_format($ingresosTotales, 2) }}
                    </h3>
                    <span class="text-xs text-gray-400 dark:text-slate-500">{{ __('Entrada total de caja') }}</span>
                </div>
                <div class="bg-emerald-50 dark:bg-emerald-950/40 p-4 rounded-xl text-emerald-600 dark:text-emerald-400">
                    <i class="fas fa-cash-register text-3xl"></i>
                </div>
            </div>

            <!-- Tarjeta de Costos/Gastos -->
            <div class="bg-white dark:bg-slate-900 rounded-2xl p-6 border border-gray-100 dark:border-slate-800 shadow-sm flex items-center justify-between transition-colors">
                <div class="space-y-2">
                    <p class="text-xs font-bold text-gray-400 dark:text-slate-400 uppercase tracking-wider">{{ __('Costos de Inversión') }}</p>
                    <h3 class="text-3xl font-black text-rose-600 dark:text-rose-400">
                        ${{ number_format($gastosTotales, 2) }}
                    </h3>
                    <span class="text-xs text-gray-400 dark:text-slate-500">{{ __('Costo total de mercancía vendida') }}</span>
                </div>
                <div class="bg-rose-50 dark:bg-rose-950/40 p-4 rounded-xl text-rose-600 dark:text-rose-400">
                    <i class="fas fa-wallet text-3xl"></i>
                </div>
            </div>

        </div>

        {{-- Accesos Rápidos --}}
        <div class="bg-white dark:bg-slate-900 rounded-2xl p-6 border border-gray-100 dark:border-slate-800 shadow-sm transition-colors space-y-4">
            <h4 class="text-sm font-bold text-gray-700 dark:text-slate-200">
                {{ __('Accesos Rápidos al Sistema') }}
            </h4>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                <!-- Botón Primario: Registrar Venta -->
                <a href="{{ route('admin.ventas.create') }}" 
                   class="py-3 px-4 font-semibold text-sm bg-indigo-600 hover:bg-indigo-700 dark:bg-indigo-500 dark:hover:bg-indigo-600 text-white rounded-xl shadow-sm text-center flex items-center justify-center transition">
                    <i class="fas fa-calculator mr-2"></i> {{ __('Registrar Venta') }}
                </a>
                
                <!-- Botón Secundario: Ir a Inventario -->
                <a href="{{ route('admin.inventario.index') }}" 
                   class="py-3 px-4 font-semibold text-sm bg-gray-50 hover:bg-gray-100 dark:bg-slate-800 dark:hover:bg-slate-700/80 text-gray-700 dark:text-slate-200 border border-gray-200 dark:border-slate-700 rounded-xl shadow-sm text-center flex items-center justify-center transition">
                    <i class="fas fa-boxes mr-2 text-gray-500 dark:text-slate-400"></i> {{ __('Ir a Inventario') }}
                </a>

                <!-- Botón Secundario: Ver ventas -->
                <a href="{{ route('admin.ventas.index') }}" 
                   class="py-3 px-4 font-semibold text-sm bg-gray-50 hover:bg-gray-100 dark:bg-slate-800 dark:hover:bg-slate-700/80 text-gray-700 dark:text-slate-200 border border-gray-200 dark:border-slate-700 rounded-xl shadow-sm text-center flex items-center justify-center transition">
                    <i class="fas fa-history mr-2 text-gray-500 dark:text-slate-400"></i> {{ __('Ver ventas realizadas') }}
                </a>
            </div>
        </div>

    </div>

</x-admin-layout>