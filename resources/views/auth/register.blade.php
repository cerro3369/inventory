<x-guest-layout>
    <div class="fixed top-5 right-5 z-50 flex items-center space-x-3">
        
        <!-- selector de idioma -->
        {{-- <div class="relative">
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
        </div> --}}

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
            <button @click="toggleTheme()" 
                    type="button"
                    aria-label="Toggle Theme"
                    class="relative inline-flex h-8 w-14 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent bg-slate-200 dark:bg-slate-800 shadow-sm hover:shadow transition-colors duration-300 ease-in-out focus:outline-none">
                
                <span class="pointer-events-none relative inline-block h-7 w-7 transform rounded-full bg-white dark:bg-slate-900 shadow-md ring-0 transition duration-300 ease-in-out"
                      :class="darkMode ? 'translate-x-6' : 'translate-x-0'">
                    
                    <span class="absolute inset-0 flex h-full w-full items-center justify-center transition-opacity duration-200"
                          :class="darkMode ? 'opacity-0 ease-out duration-100' : 'opacity-100 ease-in duration-200'">
                        <svg class="h-4 w-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </span>

                    <span class="absolute inset-0 flex h-full w-full items-center justify-center transition-opacity duration-200"
                          :class="darkMode ? 'opacity-100 ease-in duration-200' : 'opacity-0 ease-out duration-100'">
                        <svg class="h-3.5 w-3.5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                        </svg>
                    </span>
                </span>
            </button>
        </div>
    </div>

    <div class="min-h-screen flex flex-col justify-center items-center px-4 py-12 bg-slate-50 dark:bg-slate-950 transition-colors">
        
        <div class="w-full max-w-md bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 rounded-3xl p-8 shadow-xl shadow-slate-200/50 dark:shadow-none transition-all">
            
            <div class="flex flex-col items-center mb-6">
                <a href="/" class="mb-4 transition-transform hover:scale-105">
                    <img src="{{ asset('img/logo.png') }}" class="h-12 w-auto object-contain" alt="Logo Inventory" />
                </a>
                <h2 class="text-2xl font-black tracking-tight text-slate-800 dark:text-slate-100">
                    {{ __('Crear una cuenta') }}
                </h2>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">
                    {{ __('Ingresa tus datos para registrarte en la plataforma') }}
                </p>
            </div>

            <x-validation-errors class="mb-6" />

            <form method="POST" action="{{ route('register') }}" class="space-y-4">
                @csrf

                <div>
                    <label for="name" class="block text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-300 mb-1.5">
                        {{ __('Nombre completo') }}
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400 dark:text-slate-500">
                            <i class="fas fa-user text-sm"></i>
                        </div>
                        <input id="name" 
                               type="text" 
                               name="name" 
                               value="{{ old('name') }}" 
                               required 
                               autofocus 
                               placeholder="Tu nombre y apellido"
                               autocomplete="name" 
                               class="w-full pl-10 pr-4 py-2.5 text-sm bg-slate-50 dark:bg-slate-800/60 text-slate-800 dark:text-slate-100 border border-slate-200 dark:border-slate-700/80 rounded-xl focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 dark:focus:border-indigo-400 transition-all placeholder:text-slate-400 dark:placeholder:text-slate-500" />
                    </div>
                </div>

                <div>
                    <label for="email" class="block text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-300 mb-1.5">
                        {{ __('Correo Electrónico') }}
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400 dark:text-slate-500">
                            <i class="fas fa-envelope text-sm"></i>
                        </div>
                        <input id="email" 
                               type="email" 
                               name="email" 
                               value="{{ old('email') }}" 
                               required 
                               placeholder="nombre@ejemplo.com"
                               autocomplete="username" 
                               class="w-full pl-10 pr-4 py-2.5 text-sm bg-slate-50 dark:bg-slate-800/60 text-slate-800 dark:text-slate-100 border border-slate-200 dark:border-slate-700/80 rounded-xl focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 dark:focus:border-indigo-400 transition-all placeholder:text-slate-400 dark:placeholder:text-slate-500" />
                    </div>
                </div>

                <div>
                    <label for="password" class="block text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-300 mb-1.5">
                        {{ __('Contraseña') }}
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400 dark:text-slate-500">
                            <i class="fas fa-lock text-sm"></i>
                        </div>
                        <input id="password" 
                               type="password" 
                               name="password" 
                               required 
                               placeholder="••••••••"
                               autocomplete="new-password" 
                               class="w-full pl-10 pr-4 py-2.5 text-sm bg-slate-50 dark:bg-slate-800/60 text-slate-800 dark:text-slate-100 border border-slate-200 dark:border-slate-700/80 rounded-xl focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 dark:focus:border-indigo-400 transition-all placeholder:text-slate-400 dark:placeholder:text-slate-500" />
                    </div>
                </div>

                <div>
                    <label for="password_confirmation" class="block text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-300 mb-1.5">
                        {{ __('Confirmar Contraseña') }}
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400 dark:text-slate-500">
                            <i class="fas fa-shield-alt text-sm"></i>
                        </div>
                        <input id="password_confirmation" 
                               type="password" 
                               name="password_confirmation" 
                               required 
                               placeholder="••••••••"
                               autocomplete="new-password" 
                               class="w-full pl-10 pr-4 py-2.5 text-sm bg-slate-50 dark:bg-slate-800/60 text-slate-800 dark:text-slate-100 border border-slate-200 dark:border-slate-700/80 rounded-xl focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 dark:focus:border-indigo-400 transition-all placeholder:text-slate-400 dark:placeholder:text-slate-500" />
                    </div>
                </div>

                @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                    <div class="pt-1">
                        <label for="terms" class="flex items-start cursor-pointer select-none">
                            <input id="terms" 
                                   type="checkbox" 
                                   name="terms" 
                                   required 
                                   class="mt-0.5 rounded border-slate-300 dark:border-slate-700 text-indigo-600 focus:ring-indigo-500/30 dark:bg-slate-800 dark:checked:bg-indigo-500" />
                            <span class="ms-2 text-xs text-slate-600 dark:text-slate-400 leading-relaxed">
                                {!! __('Acepto los :terms_of_service y la :privacy_policy', [
                                        'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="font-semibold text-indigo-600 dark:text-indigo-400 hover:underline">'.__('Términos del Servicio').'</a>',
                                        'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="font-semibold text-indigo-600 dark:text-indigo-400 hover:underline">'.__('Política de Privacidad').'</a>',
                                ]) !!}
                            </span>
                        </label>
                    </div>
                @endif

                <div class="pt-3">
                    <button type="submit" 
                            class="w-full py-3 px-4 text-sm font-bold text-white bg-indigo-600 hover:bg-indigo-700 active:bg-indigo-800 dark:bg-indigo-500 dark:hover:bg-indigo-600 rounded-xl shadow-md shadow-indigo-500/20 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 transition-all">
                        {{ __('Registrarse') }}
                    </button>
                </div>

                <div class="text-center pt-2">
                    <a href="{{ route('login') }}" 
                       class="text-xs font-medium text-slate-600 dark:text-slate-400 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">
                        {{ __('¿Ya tienes una cuenta? Inicia sesión') }}
                    </a>
                </div>
            </form>
        </div>

        <p class="text-center text-xs text-slate-400 dark:text-slate-500 mt-6">
            &copy; {{ date('Y') }} {{ config('app.name', 'Inventory') }}. {{ __('Todos los derechos reservados.') }}
        </p>
    </div>
</x-guest-layout>