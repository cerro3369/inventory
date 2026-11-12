<nav class="fixed top-0 z-50 w-full bg-neutral-primary-soft border-b border-default h-16 flex items-center">
    <div class="px-3 py-3 lg:px-5 lg:pl-3 w-full">
        <div class="flex items-center justify-between">
            <div class="flex items-center justify-start rtl:justify-end">
                <button data-drawer-target="top-bar-sidebar" data-drawer-toggle="top-bar-sidebar"
                    aria-controls="top-bar-sidebar" type="button"
                    class="sm:hidden text-heading bg-transparent box-border border border-transparent hover:bg-neutral-secondary-medium focus:ring-4 focus:ring-neutral-tertiary font-medium leading-5 rounded-base text-sm p-2 focus:outline-none">
                    <span class="sr-only">Open sidebar</span>
                    <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                        height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-width="2"
                            d="M5 7h14M5 12h14M5 17h10" />
                    </svg>
                </button>
                <a href="{{ route('admin.dashboard') }}" class="flex ms-2 md:me-24 items-center">
                    <img src="{{ asset('img/logo.png') }}" class="h-8 me-3 object-contain" alt="Logo Inventory" />

                    <span class="self-center text-lg font-black whitespace-nowrap dark:text-white tracking-tight text-gray-800">
                        Inventory
                    </span>
                </a>
            </div>

            <div class="flex items-center gap-x-2">

                {{-- 1. Selector de Idioma --}}
                <div class="relative">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button type="button"
                                class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs leading-4 font-bold rounded-lg text-gray-600 dark:text-gray-200 bg-gray-100 hover:bg-gray-200 dark:bg-neutral-800 dark:hover:bg-neutral-700 focus:outline-none transition">
                                <i class="fas fa-globe mr-1.5 text-custom-primary"></i>
                                <span class="uppercase">{{ app()->getLocale() }}</span>
                                <svg class="ms-1.5 -me-0.5 size-3" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                </svg>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <div class="block px-4 py-2 text-xs text-gray-400 font-semibold uppercase tracking-wider">
                                {{ __('Idioma / Language') }}
                            </div>

                            <x-dropdown-link href="{{ route('admin.locale.switch', 'es') }}"
                                class="{{ app()->getLocale() == 'es' ? 'font-bold text-blue-600 bg-gray-50 dark:bg-neutral-700' : '' }}">
                                Español (ES)
                            </x-dropdown-link>

                            <x-dropdown-link href="{{ route('admin.locale.switch', 'en') }}"
                                class="{{ app()->getLocale() == 'en' ? 'font-bold text-blue-600 bg-gray-50 dark:bg-neutral-700' : '' }}">
                                English (EN)
                            </x-dropdown-link>

                            <x-dropdown-link href="{{ route('admin.locale.switch', 'fr') }}"
                                class="{{ app()->getLocale() == 'fr' ? 'font-bold text-blue-600 bg-gray-50 dark:bg-neutral-700' : '' }}">
                                Français (FR)
                            </x-dropdown-link>

                            <x-dropdown-link href="{{ route('admin.locale.switch', 'de') }}"
                                class="{{ app()->getLocale() == 'de' ? 'font-bold text-blue-600 bg-gray-50 dark:bg-neutral-700' : '' }}">
                                Deutsch (DE)
                            </x-dropdown-link>

                            <x-dropdown-link href="{{ route('admin.locale.switch', 'it') }}"
                                class="{{ app()->getLocale() == 'it' ? 'font-bold text-blue-600 bg-gray-50 dark:bg-neutral-700' : '' }}">
                                Italiano (IT)
                            </x-dropdown-link>
                        </x-slot>
                    </x-dropdown>
                </div>

                {{-- 2. BOTÓN DE CAMBIO DE TEMA (MODO SWITCH INTERACTIVO) --}}
                <div x-data="{
                    darkMode: localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches),
                    toggleTheme() {
                        this.darkMode = !this.darkMode;
                        if (this.darkMode) {
                            document.documentElement.classList.add('dark');
                            localStorage.setItem('theme', 'dark');
                        } else {
                            document.documentElement.classList.remove('dark');
                            localStorage.setItem('theme', 'light');
                        }
                    }
                }">
                    <button @click="toggleTheme()" type="button" aria-label="Toggle Theme"
                        class="relative inline-flex h-8 w-14 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent bg-gray-200 dark:bg-neutral-700 transition-colors duration-300 ease-in-out focus:outline-none">

                        <!-- Círculo Deslizante -->
                        <span
                            class="pointer-events-none relative inline-block h-7 w-7 transform rounded-full bg-white dark:bg-neutral-900 shadow-md ring-0 transition duration-300 ease-in-out"
                            :class="darkMode ? 'translate-x-6' : 'translate-x-0'">

                            <!-- Icono Sol (Modo Claro) -->
                            <span
                                class="absolute inset-0 flex h-full w-full items-center justify-center transition-opacity duration-200"
                                :class="darkMode ? 'opacity-0 ease-out duration-100' : 'opacity-100 ease-in duration-200'">
                                <svg class="h-4 w-4 text-amber-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                            </span>

                            <!-- Icono Luna (Modo Oscuro) -->
                            <span
                                class="absolute inset-0 flex h-full w-full items-center justify-center transition-opacity duration-200"
                                :class="darkMode ? 'opacity-100 ease-in duration-200' : 'opacity-0 ease-out duration-100'">
                                <svg class="h-3.5 w-3.5 text-indigo-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                                </svg>
                            </span>
                        </span>
                    </button>
                </div>

                {{-- 3. Menú de Usuario / Perfil --}}
                <div class="flex items-center ms-1">
                    <div>
                        <div class="relative">
                            <x-dropdown align="right" width="48">
                                <x-slot name="trigger">
                                    @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                                        <button
                                            class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                                            <img class="size-8 rounded-full object-cover"
                                                src="{{ Auth::user()->profile_photo_url }}"
                                                alt="{{ Auth::user()->name }}" />
                                        </button>
                                    @else
                                        <span class="inline-flex rounded-md">
                                            <button type="button"
                                                class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition ease-in-out duration-150">
                                                {{ Auth::user()->name }}
                                                <svg class="ms-2 -me-0.5 size-4" xmlns="http://www.w3.org/2000/svg"
                                                    fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                                    stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                                </svg>
                                            </button>
                                        </span>
                                    @endif
                                </x-slot>

                                <x-slot name="content">
                                    <div class="block px-4 py-2 text-xs text-gray-400">
                                        {{ __('Manage Account') }}
                                    </div>
                                    <x-dropdown-link href="{{ route('profile.show') }}">
                                        {{ __('Profile') }}
                                    </x-dropdown-link>
                                    @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                                        <x-dropdown-link href="{{ route('api-tokens.index') }}">
                                            {{ __('API Tokens') }}
                                        </x-dropdown-link>
                                    @endif
                                    <div class="border-t border-gray-200 dark:border-gray-700"></div>
                                    <form method="POST" action="{{ route('logout') }}" x-data>
                                        @csrf
                                        <x-dropdown-link href="{{ route('logout') }}"
                                            @click.prevent="$root.submit();">
                                            {{ __('Log Out') }}
                                        </x-dropdown-link>
                                    </form>
                                </x-slot>
                            </x-dropdown>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</nav>
