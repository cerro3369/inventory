@php
    $links = [
        [
            'name' => __('Dashboard'),
            'icon' => 'fa-solid fa-sliders',
            'href' => route('admin.dashboard'),
            'active' => request()->routeIs('admin.dashboard'),
        ],
        [
            'header' => __('Administrar Productos'),
        ],
        [
            'name' => __('Productos'),
            'icon' => 'fa-solid fa-book',
            'href' => route('admin.catalogo.index'),
            'active' => request()->routeIs('admin.catalogo.*'),
        ],
        [
            'name' => __('Inventario'),
            'icon' => 'fa-solid fa-boxes-stacked',
            'href' => route('admin.inventario.index'),
            'active' => request()->routeIs('admin.inventario.*'),
        ],
        [
            'name' => __('Ventas'),
            'icon' => 'fa-solid fa-brands fa-sellcast',
            'href' => route('admin.ventas.index'),
            'active' => request()->routeIs('admin.ventas.*'),
        ],
        [
            'name' => __('Mermas'),
            'icon' => 'fa-solid fa-dolly',
            'href' => route('admin.mermas.index'),
            'active' => request()->routeIs('admin.mermas.*'),
        ],
    ];
@endphp

<aside id="top-bar-sidebar"
    class="fixed top-0 left-0 z-40 w-64 h-full transition-transform -translate-x-full sm:translate-x-0"
    aria-label="Sidebar">
    <div
        class="h-full px-3 py-4 pt-20 overflow-y-auto bg-white dark:bg-[#0f172a] border-r border-gray-200 dark:border-gray-800">
        <ul class="space-y-2 font-medium">
            @foreach ($links as $link)
                <li>
                    @isset($link['header'])
                        <div class="px-2 py-2 text-xs font-semibold text-gray-500 uppercase">
                            {{ $link['header'] }}
                        </div>
                    @else
                        @isset($link['submenu'])
                            <button type="button"
                                class="flex items-center w-full justify-between px-2 py-1.5 text-body rounded-base hover:bg-neutral-tertiary hover:text-fg-brand group"
                                aria-controls="dropdown-example" data-collapse-toggle="dropdown-example">
                                <span class="w-6 h-6 inline-flex justify-center items-center text-gray-500">
                                    <i class="{{ $link['icon'] }}"></i>
                                </span>
                                <span class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap">{{ $link['name'] }}</span>
                                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="m19 9-7 7-7-7" />
                                </svg>
                            </button>
                            <ul id="dropdown-example" class="hidden py-2 space-y-2">
                                @foreach ($link['submenu'] as $item)
                                    <li>
                                        <a href="{{ $item['href'] }}"
                                            class="pl-10 flex items-center px-2 py-1.5 text-body rounded-base hover:bg-neutral-tertiary hover:text-fg-brand group">{{ __($item['name']) }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <a href="{{ $link['href'] }}"
                                class="flex items-center px-2 py-1.5 text-body rounded-base hover:bg-neutral-tertiary hover:text-fg-brand group {{ $link['active'] ? 'bg-gray-200 dark:bg-neutral-700 font-bold' : '' }}">
                                <span class="w-6 h-6 inline-flex justify-center items-center text-gray-500">
                                    <i class="{{ $link['icon'] }}"></i>
                                </span>
                                <span class="ms-3">{{ $link['name'] }}</span>
                            </a>
                        @endisset
                    @endisset
                </li>
            @endforeach
        </ul>
    </div>
</aside>