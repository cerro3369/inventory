<x-guest-layout>
    <div class="min-h-screen flex flex-col justify-center items-center px-4 py-12 bg-slate-50 dark:bg-slate-950 transition-colors">
        
        <!-- Tarjeta Principal de Registro -->
        <div class="w-full max-w-md bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 rounded-3xl p-8 shadow-xl shadow-slate-200/50 dark:shadow-none transition-all">
            
            <!-- Encabezado con Logo y Título -->
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

            <!-- Errores de Validación -->
            <x-validation-errors class="mb-6" />

            <!-- Formulario de Registro -->
            <form method="POST" action="{{ route('register') }}" class="space-y-4">
                @csrf

                <!-- Campo Nombre -->
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
                               autocomplete="new-password" 
                               class="w-full pl-10 pr-4 py-2.5 text-sm bg-slate-50 dark:bg-slate-800/60 text-slate-800 dark:text-slate-100 border border-slate-200 dark:border-slate-700/80 rounded-xl focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 dark:focus:border-indigo-400 transition-all placeholder:text-slate-400 dark:placeholder:text-slate-500" />
                    </div>
                </div>

                <!-- Campo Confirmar Contraseña -->
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

                <!-- Términos y Condiciones (Jetstream) -->
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

                <!-- Botón de Registro -->
                <div class="pt-3">
                    <button type="submit" 
                            class="w-full py-3 px-4 text-sm font-bold text-white bg-indigo-600 hover:bg-indigo-700 active:bg-indigo-800 dark:bg-indigo-500 dark:hover:bg-indigo-600 rounded-xl shadow-md shadow-indigo-500/20 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 transition-all">
                        {{ __('Registrarse') }}
                    </button>
                </div>

                <!-- Enlace a Login -->
                <div class="text-center pt-2">
                    <a href="{{ route('login') }}" 
                       class="text-xs font-medium text-slate-600 dark:text-slate-400 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">
                        {{ __('¿Ya tienes una cuenta? Inicia sesión') }}
                    </a>
                </div>
            </form>
        </div>

        <!-- Pie de página -->
        <p class="text-center text-xs text-slate-400 dark:text-slate-500 mt-6">
            &copy; {{ date('Y') }} {{ config('app.name', 'Inventory') }}. {{ __('Todos los derechos reservados.') }}
        </p>
    </div>
</x-guest-layout>