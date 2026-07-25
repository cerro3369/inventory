<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- FontAwesome para los iconos del tema y los inputs -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

        <!-- Anti-FOUC Script (Aplica la clase 'dark' antes de renderizar la página para evitar parpadeos) -->
        <script>
            if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        </script>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Styles -->
        @livewireStyles
    </head>
    <body class="bg-slate-50 dark:bg-slate-950 transition-colors duration-200">
        
        <!-- Botón de cambio de tema flotante (Esquina superior derecha) -->
        <div class="fixed top-5 right-5 z-50" 
             x-data="{
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
                    class="p-2.5 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-md hover:shadow-lg text-slate-600 dark:text-slate-300 transition-all focus:outline-none">
                
                <!-- Sol: visible en Tema Claro -->
                <svg x-show="!darkMode" class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
                </svg>

                <!-- Luna: visible en Tema Oscuro -->
                <svg x-show="darkMode" class="w-5 h-5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
                </svg>
            </button>
        </div>

        <div class="font-sans text-gray-900 dark:text-slate-100 antialiased">
            {{ $slot }}
        </div>

        @livewireScripts
    </body>
</html>