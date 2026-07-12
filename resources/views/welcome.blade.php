<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Dompetku') }} — Atur Duitmu, Tetap Aesthetic</title>

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

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @endif

        <style>
            body { font-family: 'Plus Jakarta Sans', sans-serif; }
            .glass-card {
                background: rgba(255, 253, 249, 0.65);
                backdrop-filter: blur(14px);
                -webkit-backdrop-filter: blur(14px);
                border: 2px solid rgba(204, 107, 69, 0.12);
            }
            .dark .glass-card {
                background: rgba(41, 31, 26, 0.6);
                border: 2px solid rgba(237, 173, 143, 0.08);
            }
            @keyframes float {
                0% { transform: translateY(0px) rotate(0deg); }
                50% { transform: translateY(-12px) rotate(2deg); }
                100% { transform: translateY(0px) rotate(0deg); }
            }
            .float-animation { animation: float 6s ease-in-out infinite; }
        </style>
    </head>
    <body class="antialiased text-stone-800 dark:text-stone-100">
        <div class="min-h-screen bg-gradient-to-br from-sand-50 via-blush-50/50 to-clay-50/40 dark:from-stone-950 dark:via-stone-900 dark:to-stone-950 transition-colors duration-300">

            <!-- Top bar -->
            <header class="max-w-6xl mx-auto px-6 py-6 flex items-center justify-between">
                <a href="/" class="flex items-center gap-2">
                    <span class="flex items-center justify-center w-10 h-10 rounded-2xl bg-gradient-to-br from-clay-400 to-blush-400 text-white shadow-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 7.5A2.5 2.5 0 015.5 5h11A2.5 2.5 0 0119 7.5v9a2.5 2.5 0 01-2.5 2.5h-11A2.5 2.5 0 013 16.5v-9z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12.75a1.25 1.25 0 100-2.5 1.25 1.25 0 000 2.5z"/>
                        </svg>
                    </span>
                    <span class="font-extrabold text-lg tracking-tight">Dompetku</span>
                </a>

                <nav class="flex items-center gap-3">
                    <x-theme-toggle />
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}"
                               class="rounded-full bg-clay-500 px-5 py-2 text-sm font-bold text-white hover:bg-clay-600 transition shadow-sm">
                                Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}"
                               class="rounded-full px-4 py-2 text-sm font-semibold text-stone-600 dark:text-stone-300 hover:bg-clay-50 dark:hover:bg-stone-800 transition">
                                Masuk
                            </a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}"
                                   class="rounded-full bg-clay-500 px-5 py-2 text-sm font-bold text-white hover:bg-clay-600 transition shadow-sm">
                                    Daftar Gratis
                                </a>
                            @endif
                        @endauth
                    @endif
                </nav>
            </header>

            <!-- Hero -->
            <main class="max-w-6xl mx-auto px-6 pt-10 pb-20">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                    <div class="text-center lg:text-left">
                        <span class="inline-block text-xs font-extrabold uppercase tracking-widest text-clay-600 dark:text-clay-300 bg-clay-500/10 px-3.5 py-1.5 rounded-xl mb-4">#AturDuitBiarGaBoncos 💸</span>
                        <h1 class="text-4xl sm:text-5xl font-extrabold leading-tight text-stone-900 dark:text-white">
                            Atur duitmu,<br class="hidden lg:block"> tetap <span class="text-clay-500">aesthetic</span>.
                        </h1>
                        <p class="mt-5 text-stone-500 dark:text-stone-400 max-w-md mx-auto lg:mx-0">
                            Catat pemasukan, pengeluaran, dan dompetmu dalam satu tempat yang enak dilihat. Bebas ribet, bebas boncos.
                        </p>
                        <div class="mt-8 flex flex-col sm:flex-row items-center gap-3 justify-center lg:justify-start">
                            @auth
                                <a href="{{ url('/dashboard') }}" class="w-full sm:w-auto rounded-full bg-clay-500 px-6 py-3 text-sm font-bold text-white hover:bg-clay-600 transition shadow-md text-center">
                                    Buka Dashboard →
                                </a>
                            @else
                                <a href="{{ route('register') }}" class="w-full sm:w-auto rounded-full bg-clay-500 px-6 py-3 text-sm font-bold text-white hover:bg-clay-600 transition shadow-md text-center">
                                    Mulai Sekarang →
                                </a>
                                <a href="{{ route('login') }}" class="w-full sm:w-auto rounded-full border border-clay-200 dark:border-stone-700 px-6 py-3 text-sm font-bold text-stone-700 dark:text-stone-300 hover:bg-clay-50 dark:hover:bg-stone-800 transition text-center">
                                    Masuk
                                </a>
                            @endauth
                        </div>
                    </div>

                    <!-- Decorative illustration -->
                    <div class="relative w-full max-w-sm mx-auto float-animation">
                        <svg viewBox="0 0 300 300" class="w-full h-auto">
                            <defs>
                                <linearGradient id="heroBlobGrad" x1="0%" y1="0%" x2="100%" y2="100%">
                                    <stop offset="0%" stop-color="#F5CDBC" />
                                    <stop offset="100%" stop-color="#D2D9BA" />
                                </linearGradient>
                            </defs>
                            <path fill="url(#heroBlobGrad)" opacity="0.9" d="M63.4,-71.3C79.9,-59.5,89.9,-38.2,91.7,-17.2C93.5,3.9,87.2,24.6,74.9,41.1C62.6,57.6,44.3,69.9,24.2,75.5C4.1,81.1,-17.9,80.1,-36.9,71.9C-55.9,63.7,-71.9,48.4,-79.6,29.6C-87.3,10.8,-86.7,-11.5,-77.9,-29.3C-69.1,-47.1,-52.1,-60.4,-34.2,-71.5C-16.3,-82.6,2.5,-91.5,21.6,-89.5C40.7,-87.5,46.9,-83.1,63.4,-71.3Z" transform="translate(150 150)" />
                            <g transform="translate(85 105)">
                                <rect x="0" y="20" width="130" height="90" rx="18" fill="#FFFDF9" stroke="#CC6B45" stroke-width="4"/>
                                <path d="M0 50 H130" stroke="#CC6B45" stroke-width="4"/>
                                <circle cx="100" cy="78" r="12" fill="#CC6B45"/>
                                <path d="M14 20 L34 -10 H96 L116 20" fill="none" stroke="#CC6B45" stroke-width="4" stroke-linejoin="round"/>
                            </g>
                            <circle cx="230" cy="90" r="10" fill="#9AAC70" opacity="0.9"/>
                            <circle cx="245" cy="200" r="7" fill="#DC7A8A" opacity="0.9"/>
                            <circle cx="55" cy="230" r="8" fill="#E08863" opacity="0.9"/>
                        </svg>
                    </div>
                </div>

                <!-- Feature highlights -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mt-20">
                    <div class="glass-card rounded-3xl p-6 shadow-sm">
                        <div class="w-11 h-11 rounded-2xl bg-sage-500/10 text-sage-600 dark:text-sage-400 flex items-center justify-center mb-4">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6M9 8h6M5 21V5a2 2 0 012-2h6l6 6v12a2 2 0 01-2 2H7a2 2 0 01-2-2z"/>
                            </svg>
                        </div>
                        <h3 class="font-extrabold text-stone-900 dark:text-white mb-1">Catat Transaksi</h3>
                        <p class="text-sm text-stone-500 dark:text-stone-400">Simpan tiap pemasukan dan pengeluaran, lengkap dengan kategori dan catatan.</p>
                    </div>
                    <div class="glass-card rounded-3xl p-6 shadow-sm">
                        <div class="w-11 h-11 rounded-2xl bg-clay-500/10 text-clay-600 dark:text-clay-400 flex items-center justify-center mb-4">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 7.5A2.5 2.5 0 015.5 5h11A2.5 2.5 0 0119 7.5v9a2.5 2.5 0 01-2.5 2.5h-11A2.5 2.5 0 013 16.5v-9z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12.75a1.25 1.25 0 100-2.5 1.25 1.25 0 000 2.5z"/>
                            </svg>
                        </div>
                        <h3 class="font-extrabold text-stone-900 dark:text-white mb-1">Kelola Dompet</h3>
                        <p class="text-sm text-stone-500 dark:text-stone-400">Pisahkan tabungan, jajan harian, dan e-wallet biar ga kecampur.</p>
                    </div>
                    <div class="glass-card rounded-3xl p-6 shadow-sm">
                        <div class="w-11 h-11 rounded-2xl bg-blush-500/10 text-blush-600 dark:text-blush-400 flex items-center justify-center mb-4">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6a7.5 7.5 0 107.5 7.5h-7.5V6z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 10.5H21A7.5 7.5 0 0013.5 3v7.5z"/>
                            </svg>
                        </div>
                        <h3 class="font-extrabold text-stone-900 dark:text-white mb-1">Lihat Insight</h3>
                        <p class="text-sm text-stone-500 dark:text-stone-400">Grafik arus kas dan rincian kategori biar makin ngerti kemana perginya duit.</p>
                    </div>
                </div>
            </main>

            <footer class="text-center text-xs text-stone-400 dark:text-stone-500 pb-8">
                &copy; {{ date('Y') }} Dompetku. Dibuat dengan Laravel.
            </footer>
        </div>
    </body>
</html>
