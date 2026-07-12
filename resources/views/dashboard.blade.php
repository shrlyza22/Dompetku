<x-app-layout>
    <x-slot name="title">{{ __('Dashboard') }}</x-slot>
    <x-slot name="header">
        <h2 class="font-extrabold text-xl text-stone-800 dark:text-stone-200 leading-tight">
            {{ __('Halo, :name! 👋', ['name' => auth()->user()->name]) }}
        </h2>
    </x-slot>
    <x-slot name="footer">1</x-slot>

    <div class="pt-8 pb-16">
        <div class="max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-10">

            <!-- Welcome Header (Gen-Z Style) -->
            <div class="relative overflow-hidden glass-card p-8 rounded-3xl mb-8 flex flex-col md:flex-row items-center justify-between gap-6 border-clay-500/10 glow-clay">
                <div class="z-10 text-center md:text-left">
                    <span class="inline-block text-xs font-extrabold uppercase tracking-widest text-clay-600 dark:text-clay-300 bg-clay-500/10 px-3.5 py-1.5 rounded-xl mb-3">#AturDuitBiarGaBoncos 💸</span>
                    <h1 class="text-3xl font-extrabold text-stone-900 dark:text-white leading-tight">
                        {{ __('Atur Duitmu, Bebas Boncos! 🚀') }}
                    </h1>
                    <p class="text-stone-500 dark:text-stone-400 text-sm mt-2 max-w-lg">
                        {{ __('Gimana nih finansial kamu bulan ini? Yuk catat terus pemasukan dan pengeluaran kamu biar saldo tabungan tetep aman dan bebas boncos! 🚀') }}
                    </p>
                </div>
                <!-- Decorative illustration -->
                <div class="flex-shrink-0 relative w-40 h-40 md:w-48 md:h-48 float-animation">
                    <svg viewBox="0 0 200 200" class="w-full h-full">
                        <defs>
                            <linearGradient id="blobGrad" x1="0%" y1="0%" x2="100%" y2="100%">
                                <stop offset="0%" stop-color="#F5CDBC" />
                                <stop offset="100%" stop-color="#F3C7CE" />
                            </linearGradient>
                        </defs>
                        <path fill="url(#blobGrad)" d="M45.2,-58.4C58.4,-49.9,68.7,-35.6,72.6,-19.7C76.6,-3.8,74.3,13.7,66.6,28.4C58.9,43.1,45.9,55,30.9,63.2C15.9,71.4,-1.1,75.9,-17.6,72.7C-34.1,69.5,-50.1,58.6,-60.6,43.7C-71.1,28.8,-76.1,9.9,-73.5,-7.5C-70.9,-24.9,-60.7,-40.8,-47.1,-49.3C-33.5,-57.8,-16.7,-58.9,0.6,-59.7C17.9,-60.5,35.9,-61,45.2,-58.4Z" transform="translate(100 100)" />
                        <circle cx="70" cy="60" r="7" fill="#E08863" opacity="0.8"/>
                        <circle cx="140" cy="130" r="5" fill="#9AAC70" opacity="0.8"/>
                        <circle cx="145" cy="55" r="4" fill="#DC7A8A" opacity="0.8"/>
                        <g transform="translate(62 78)">
                            <rect x="0" y="10" width="76" height="52" rx="12" fill="#FFFDF9" stroke="#CC6B45" stroke-width="3"/>
                            <path d="M0 28 H76" stroke="#CC6B45" stroke-width="3"/>
                            <circle cx="58" cy="45" r="7" fill="#CC6B45"/>
                            <path d="M8 10 L20 -6 H56 L68 10" fill="none" stroke="#CC6B45" stroke-width="3" stroke-linejoin="round"/>
                        </g>
                    </svg>
                </div>
            </div>

            <!-- Summary Cards Section (Custom Playful Copy) -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                <!-- Income Card -->
                <div class="glass-card overflow-hidden shadow-sm sm:rounded-3xl p-6 flex items-center justify-between transition-all duration-300 hover:shadow-lg hover:scale-[1.02] border-sage-500/20 glow-sage">
                    <div>
                        <p class="text-xs font-extrabold text-sage-600 dark:text-sage-400 uppercase tracking-wider">{{ __('Cuan & Gaji Masuk 📈') }}</p>
                        <h3 class="text-2xl font-extrabold text-stone-900 dark:text-white mt-1">
                            Rp {{ number_format($totalIncome, 0, ',', '.') }}
                        </h3>
                    </div>
                    <div class="p-3 bg-sage-500/10 rounded-2xl text-sage-600 dark:text-sage-400">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                        </svg>
                    </div>
                </div>

                <!-- Expense Card -->
                <div class="glass-card overflow-hidden shadow-sm sm:rounded-3xl p-6 flex items-center justify-between transition-all duration-300 hover:shadow-lg hover:scale-[1.02] border-blush-500/20 glow-blush">
                    <div>
                        <p class="text-xs font-extrabold text-blush-600 dark:text-blush-400 uppercase tracking-wider">{{ __('Belanja & Jajan Keluar 📉') }}</p>
                        <h3 class="text-2xl font-extrabold text-stone-900 dark:text-white mt-1">
                            Rp {{ number_format($totalExpense, 0, ',', '.') }}
                        </h3>
                    </div>
                    <div class="p-3 bg-blush-500/10 rounded-2xl text-blush-600 dark:text-blush-400">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 17h8m0 0v-8m0 8l-8-8-4 4-6-6"/>
                        </svg>
                    </div>
                </div>

                <!-- Net Balance Card -->
                <div class="glass-card overflow-hidden shadow-sm sm:rounded-3xl p-6 flex items-center justify-between transition-all duration-300 hover:shadow-lg hover:scale-[1.02] border-clay-500/20 glow-clay">
                    <div>
                        <p class="text-xs font-extrabold text-clay-600 dark:text-clay-400 uppercase tracking-wider">{{ __('Uang Aman Kamu 💰') }}</p>
                        <h3 class="text-2xl font-extrabold mt-1 {{ $netBalance >= 0 ? 'text-sage-600 dark:text-sage-400' : 'text-blush-600 dark:text-blush-400' }}">
                            Rp {{ number_format($netBalance, 0, ',', '.') }}
                        </h3>
                    </div>
                    <div class="p-3 bg-clay-500/10 rounded-2xl text-clay-600 dark:text-clay-400">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M12 16v1M10 12h4"/>
                        </svg>
                    </div>
                </div>

            </div>

            <!-- Chart & Recent Transactions Section -->
            <div class="grid grid-cols-1 lg:grid-cols-5 gap-6 mt-8">

                <!-- Charts Area (Col Span 3) -->
                <div class="lg:col-span-3 glass-card overflow-hidden shadow-sm sm:rounded-3xl p-6">
                    <h3 class="text-md font-extrabold text-stone-800 dark:text-stone-200 mb-1 flex items-center gap-1.5">{{ __('Arus Kas & Pengeluaran 📊') }}</h3>
                    <p class="text-xs text-stone-500 dark:text-stone-400 mb-6">{{ __('Visualisasi pemasukan vs pengeluaran dan rincian alur kas kategori bulan ini') }}</p>
 
                    @if ($totalIncome == 0 && $totalExpense == 0)
                        <div class="py-12 text-center text-stone-400 dark:text-stone-500">
                            <svg class="w-12 h-12 mx-auto mb-2 text-stone-300 dark:text-stone-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6a7.5 7.5 0 107.5 7.5h-7.5V6z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 10.5H21A7.5 7.5 0 0013.5 3v7.5z"/>
                            </svg>
                            <span class="text-sm font-semibold">{{ __('Belum ada catatan bulan ini.') }}</span>
                        </div>
                    @else
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 items-center">
                            <!-- Chart 1: Doughnut Chart -->
                            <div class="flex flex-col items-center justify-center border-b md:border-b-0 md:border-r border-clay-100 dark:border-stone-800/80 pb-6 md:pb-0 md:pr-6">
                                <h4 class="text-xs font-extrabold text-stone-500 dark:text-stone-400 uppercase tracking-wider mb-4">{{ __('Cuan vs Belanja ⚖️') }}</h4>
                                <div class="relative w-full max-w-[200px] h-[200px] flex items-center justify-center">
                                    <canvas id="financeChart"></canvas>
                                </div>
                            </div>
 
                            <!-- Chart 2: Horizontal Bar Chart -->
                            <div class="flex flex-col justify-center w-full min-h-[220px]">
                                <h4 class="text-xs font-extrabold text-stone-500 dark:text-stone-400 uppercase tracking-wider text-center md:text-left mb-4">{{ __('Rincian Boncos per Kategori 🍔') }}</h4>
                                @if($expenseByCategory->isEmpty())
                                    <p class="text-center text-xs text-stone-400 dark:text-stone-500 my-auto">{{ __('Belum ada pengeluaran berkategori.') }}</p>
                                @else
                                    <div class="relative w-full h-[200px]">
                                        <canvas id="categoryChart"></canvas>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
 
                <!-- Recent Transactions Widget (Col Span 2) -->
                <div class="lg:col-span-2 glass-card overflow-hidden shadow-sm sm:rounded-3xl p-6 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <h3 class="text-md font-extrabold text-stone-800 dark:text-stone-200 flex items-center gap-1.5">{{ __('Aktivitas Duit Kamu ⏰') }}</h3>
                                <p class="text-xs text-stone-500 dark:text-stone-400 mt-0.5">{{ __('Daftar pemasukan dan jajan terakhir') }}</p>
                            </div>
                            <a href="{{ route('transactions.index') }}" class="text-xs font-bold text-clay-600 dark:text-clay-400 hover:text-clay-700 dark:hover:text-clay-300 transition-colors">
                                {!! __('Lihat Semua &rarr;') !!}
                            </a>
                        </div>

                        <div class="divide-y divide-clay-100 dark:divide-stone-800/60 overflow-hidden">
                            @forelse ($recentTransactions as $trx)
                                <div class="flex items-center justify-between py-3 hover:bg-clay-500/5 px-2 rounded-2xl transition-colors">
                                    <div class="flex items-center gap-3">
                                        <div class="p-2 rounded-xl {{ $trx->type === 'income' ? 'bg-sage-500/10 text-sage-600 dark:text-sage-400' : 'bg-blush-500/10 text-blush-600 dark:text-blush-400' }}">
                                            @if ($trx->type === 'income')
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/>
                                                </svg>
                                            @else
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 15.75l7.5-7.5 7.5 7.5"/>
                                                </svg>
                                            @endif
                                        </div>
                                        <div>
                                            <h4 class="text-sm font-bold text-stone-900 dark:text-white flex flex-wrap items-center gap-1.5">
                                                {{ $trx->title }}
                                                @if($trx->category)
                                                    <span class="inline-block text-[9px] font-bold px-1.5 py-0.5 rounded-md" style="background-color: {{ $trx->category->color }}15; color: {{ $trx->category->color }};">
                                                        {{ $trx->category->name }}
                                                    </span>
                                                @endif
                                            </h4>
                                            <p class="text-xs text-stone-400 dark:text-stone-500">{{ $trx->date->format('d M Y') }}</p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-sm font-extrabold {{ $trx->type === 'income' ? 'text-sage-600 dark:text-sage-400' : 'text-blush-600 dark:text-blush-400' }}">
                                            {{ $trx->type === 'income' ? '+' : '-' }} Rp {{ number_format($trx->amount, 0, ',', '.') }}
                                        </p>
                                        @if($trx->wallet)
                                            <p class="text-[9px] font-bold text-stone-400 dark:text-stone-500">{{ $trx->wallet->name }}</p>
                                        @endif
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-10 text-stone-400 dark:text-stone-500">
                                    <svg class="w-10 h-10 mx-auto mb-2 text-stone-300 dark:text-stone-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <span class="text-sm font-semibold">{{ __('Belum ada transaksi. Yuk catat pengeluaran pertama!') }}</span>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>

    <!-- Chart.js Script Integration -->
    @if ($totalIncome > 0 || $totalExpense > 0)
        @push('scripts')
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    const isDarkMode = document.documentElement.classList.contains('dark') ||
                                       window.matchMedia('(prefers-color-scheme: dark)').matches;

                    const labelColor = isDarkMode ? '#D6D3D1' : '#57534E';

                    // 1. DOUGHNUT CHART (Pemasukan vs Pengeluaran)
                    const ctxFinance = document.getElementById('financeChart');
                    if (ctxFinance) {
                        new Chart(ctxFinance.getContext('2d'), {
                            type: 'doughnut',
                            data: {
                                labels: ['{{ __('Masuk') }}', '{{ __('Keluar') }}'],
                                datasets: [{
                                    data: [{{ $totalIncome }}, {{ $totalExpense }}],
                                    backgroundColor: [
                                        '#7F9457', // Sage 500
                                        '#C85B6D'  // Blush 500
                                    ],
                                    borderWidth: isDarkMode ? 2 : 1,
                                    borderColor: isDarkMode ? '#1C1917' : '#FFFDF9',
                                    hoverOffset: 4
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                plugins: {
                                    legend: {
                                        position: 'bottom',
                                        labels: {
                                            color: labelColor,
                                            font: {
                                                family: 'Plus Jakarta Sans, sans-serif',
                                                size: 10,
                                                weight: '700'
                                            },
                                            padding: 10,
                                            boxWidth: 10,
                                            usePointStyle: true,
                                            pointStyle: 'circle'
                                        }
                                    },
                                    tooltip: {
                                        callbacks: {
                                            label: function(context) {
                                                let label = context.label || '';
                                                if (label) label += ': ';
                                                if (context.parsed !== null) {
                                                    label += 'Rp ' + new Intl.NumberFormat('id-ID').format(context.parsed);
                                                }
                                                return label;
                                            }
                                        }
                                    }
                                },
                                cutout: '65%'
                            }
                        });
                    }

                    // 2. HORIZONTAL BAR CHART (Pengeluaran per Kategori)
                    @if ($expenseByCategory->isNotEmpty())
                        const ctxCategory = document.getElementById('categoryChart');
                        if (ctxCategory) {
                            new Chart(ctxCategory.getContext('2d'), {
                                type: 'bar',
                                data: {
                                    labels: {!! json_encode($expenseByCategory->pluck('name')) !!},
                                    datasets: [{
                                        data: {!! json_encode($expenseByCategory->pluck('total')) !!},
                                        backgroundColor: {!! json_encode($expenseByCategory->pluck('color')) !!},
                                        borderWidth: 0,
                                        borderRadius: 6,
                                        barThickness: 14
                                    }]
                                },
                                options: {
                                    indexAxis: 'y',
                                    responsive: true,
                                    maintainAspectRatio: false,
                                    plugins: {
                                        legend: {
                                            display: false
                                        },
                                        tooltip: {
                                            callbacks: {
                                                label: function(context) {
                                                    return 'Rp ' + new Intl.NumberFormat('id-ID').format(context.raw);
                                                }
                                            }
                                        }
                                    },
                                    scales: {
                                        x: {
                                            grid: {
                                                color: isDarkMode ? '#44403C' : '#F5E7D3',
                                                drawBorder: false
                                            },
                                            ticks: {
                                                color: labelColor,
                                                font: { size: 9, family: 'Plus Jakarta Sans', weight: '600' },
                                                callback: function(value) {
                                                    if (value >= 1000000) return (value / 1000000) + 'jt';
                                                    if (value >= 1000) return (value / 1000) + 'rb';
                                                    return value;
                                                }
                                            }
                                        },
                                        y: {
                                            grid: {
                                                display: false
                                            },
                                            ticks: {
                                                color: labelColor,
                                                font: {
                                                    size: 9,
                                                    weight: '700',
                                                    family: 'Plus Jakarta Sans'
                                                }
                                            }
                                        }
                                    }
                                }
                            });
                        }
                    @endif
                });
            </script>
        @endpush
    @endif
</x-app-layout>
