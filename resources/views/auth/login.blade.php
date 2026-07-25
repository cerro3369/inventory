<x-guest-layout>
    <div class="min-h-screen flex flex-col justify-center items-center px-4 py-12 bg-slate-50 dark:bg-slate-950 transition-colors">
        
        <!-- Tarjeta Principal de Login -->
        <div class="w-full max-w-md bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 rounded-3xl p-8 shadow-xl shadow-slate-200/50 dark:shadow-none transition-all">
            
            <!-- Encabezado con Logo y Título -->
            <div class="flex flex-col items-center mb-8">
                <a href="/" class="mb-4 transition-transform hover:scale-105">
                    <img src="{{ asset('img/logo.png') }}" class="h-12 w-auto object-contain" alt="Logo Inventory" />
                </a>
                <h2 class="text-2xl font-black tracking-tight text-slate-800 dark:text-slate-100">
                    {{ __('¡Bienvenido de nuevo!') }}
                </h2>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">
                    {{ __('Ingresa tus credenciales para acceder al sistema') }}
                </p>
            </div>

            <!-- Errores de Validación -->
            <x-validation-errors class="mb-6" />

            <!-- Mensaje de Estado / Sesión -->
            @session('status')
                <div class="mb-6 p-3 rounded-xl bg-emerald-50 dark:bg-emerald-950/50 border border-emerald-200 dark:border-emerald-800 font-medium text-xs text-emerald-600 dark:text-emerald-400">
                    {{ $value }}
                </div>
            @endsession

            <!-- Formulario de Login -->
            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                <!-- Campo Email -->
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
                               autofocus 
                               placeholder="nombre@ejemplo.com"
                               autocomplete="username" 
                               class="w-full pl-10 pr-4 py-2.5 text-sm bg-slate-50 dark:bg-slate-800/60 text-slate-800 dark:text-slate-100 border border-slate-200 dark:border-slate-700/80 rounded-xl focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 dark:focus:border-indigo-400 transition-all placeholder:text-slate-400 dark:placeholder:text-slate-500" />
                    </div>
                </div>

                <!-- Campo Contraseña -->
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
                               autocomplete="current-password" 
                               class="w-full pl-10 pr-4 py-2.5 text-sm bg-slate-50 dark:bg-slate-800/60 text-slate-800 dark:text-slate-100 border border-slate-200 dark:border-slate-700/80 rounded-xl focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 dark:focus:border-indigo-400 transition-all placeholder:text-slate-400 dark:placeholder:text-slate-500" />
                    </div>
                </div>

                <!-- Recordarme y Olvidé Contraseña -->
                <div class="flex items-center justify-between text-xs pt-1">
                    <label for="remember_me" class="inline-flex items-center cursor-pointer select-none">
                        <input id="remember_me" 
                               type="checkbox" 
                               name="remember" 
                               class="rounded border-slate-300 dark:border-slate-700 text-indigo-600 focus:ring-indigo-500/30 dark:bg-slate-800 dark:checked:bg-indigo-500" />
                        <span class="ms-2 text-slate-600 dark:text-slate-400 hover:text-slate-800 dark:hover:text-slate-200 transition-colors">
                            {{ __('Recordarme') }}
                        </span>
                    </label>

                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" 
                           class="font-medium text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-300 transition-colors">
                            {{ __('¿Olvidaste tu contraseña?') }}
                        </a>
                    @endif
                </div>

                <!-- Botón de Enviar -->
                <div class="pt-2">
                    <button type="submit" 
                            class="w-full py-3 px-4 text-sm font-bold text-white bg-indigo-600 hover:bg-indigo-700 active:bg-indigo-800 dark:bg-indigo-500 dark:hover:bg-indigo-600 rounded-xl shadow-md shadow-indigo-500/20 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 transition-all">
                        {{ __('Iniciar Sesión') }}
                    </button>
                </div>
            </form>
        </div>

        <!-- Pie de página opcional -->
        <p class="text-center text-xs text-slate-400 dark:text-slate-500 mt-6">
            &copy; {{ date('Y') }} {{ config('app.name', 'Inventory') }}. {{ __('Todos los derechos reservados.') }}
        </p>
    </div>
</x-guest-layout>