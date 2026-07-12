<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Dompetku') }}</title>

        <!-- Apply dark mode class before first paint to avoid flash / mismatched theming -->
        <script>
            (function () {
                const stored = localStorage.getItem('theme');
                const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
                if (stored ? stored === 'dark' : prefersDark) {
                    document.documentElement.classList.add('dark');
                }
            })();
            function toggleTheme() {
                const isDark = document.documentElement.classList.toggle('dark');
                localStorage.setItem('theme', isDark ? 'dark' : 'light');
            }
        </script>

        <!-- Fonts: Plus Jakarta Sans (consistent with the app) -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            body { font-family: 'Plus Jakarta Sans', sans-serif !important; }
            .glass-card {
                background: rgba(255, 253, 249, 0.75) !important;
                backdrop-filter: blur(16px) !important;
                -webkit-backdrop-filter: blur(16px) !important;
                border: 2px solid rgba(204, 107, 69, 0.12) !important;
            }
            .dark .glass-card {
                background: rgba(41, 31, 26, 0.7) !important;
                border: 2px solid rgba(237, 173, 143, 0.08) !important;
            }
        </style>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-10 sm:pt-0 px-4 bg-gradient-to-br from-sand-50 via-blush-50/50 to-clay-50/40 dark:from-stone-950 dark:via-stone-900 dark:to-stone-950 transition-colors duration-300">
            <div class="w-full sm:max-w-md flex items-center justify-between px-1">
                <a href="/" class="flex items-center gap-2">
                    <span class="flex items-center justify-center w-12 h-12 rounded-2xl bg-gradient-to-br from-clay-400 to-blush-400 text-white shadow-md">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 7.5A2.5 2.5 0 015.5 5h11A2.5 2.5 0 0119 7.5v9a2.5 2.5 0 01-2.5 2.5h-11A2.5 2.5 0 013 16.5v-9z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12.75a1.25 1.25 0 100-2.5 1.25 1.25 0 000 2.5z"/>
                        </svg>
                    </span>
                    <span class="font-extrabold text-xl text-stone-800 dark:text-stone-100 tracking-tight">Dompetku</span>
                </a>
                <x-theme-toggle />
            </div>

            <div class="w-full sm:max-w-md mt-6 px-6 py-6 glass-card shadow-lg overflow-hidden rounded-3xl">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
