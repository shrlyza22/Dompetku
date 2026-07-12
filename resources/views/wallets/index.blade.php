<x-app-layout>
    <x-slot name="title">{{ __('Dompet') }}</x-slot>
    <x-slot name="header">
        <h2 class="text-xl font-extrabold text-stone-800 dark:text-stone-200">{{ __('Kelola Dompet (Wallets)') }}</h2>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-screen-xl px-4 sm:px-6 lg:px-10">

            <!-- Header Banner (Gen-Z Style) -->
            <div class="relative overflow-hidden glass-card p-6 rounded-3xl mb-8 flex flex-col md:flex-row items-center justify-between gap-6 border-clay-500/10 glow-clay">
                <div class="z-10 text-center md:text-left col-span-2">
                    <h1 class="text-2xl font-extrabold text-stone-900 dark:text-white leading-tight">
                        {{ __('Dompet Jajan & Tabungan 💳') }}
                    </h1>
                    <p class="text-stone-500 dark:text-stone-400 text-sm mt-1 max-w-md">
                        {{ __('Kelola wadah uang kamu secara pintar. Bikin dompet berbeda untuk tabungan, jajan harian, atau e-wallet biar ga kecampur!') }}
                    </p>
                </div>
                <!-- Decorative illustration -->
                <div class="flex-shrink-0 relative w-28 h-28 md:w-32 md:h-32 float-animation">
                    <svg viewBox="0 0 200 200" class="w-full h-full">
                        <defs>
                            <linearGradient id="walletBlobGrad" x1="0%" y1="0%" x2="100%" y2="100%">
                                <stop offset="0%" stop-color="#EDAD8F" />
                                <stop offset="100%" stop-color="#D2D9BA" />
                            </linearGradient>
                        </defs>
                        <path fill="url(#walletBlobGrad)" opacity="0.9" d="M48.7,-56.7C61.4,-46.6,68.7,-29.6,70.6,-12.2C72.6,5.2,69.2,23,59.6,37.1C50,51.2,34.2,61.6,17.1,66.2C0,70.8,-18.4,69.6,-33.7,61.8C-49,54,-61.2,39.6,-66.6,22.9C-72,6.2,-70.6,-12.8,-62.7,-27.8C-54.8,-42.8,-40.4,-53.8,-25.5,-63C-10.6,-72.2,4.8,-79.6,20.1,-77.4C35.4,-75.2,36,-66.8,48.7,-56.7Z" transform="translate(100 100)" />
                        <g transform="translate(52 68)">
                            <rect x="0" y="0" width="96" height="64" rx="14" fill="#FFFDF9" stroke="#AD5636" stroke-width="3"/>
                            <rect x="0" y="14" width="96" height="14" fill="#AD5636" opacity="0.85"/>
                            <rect x="10" y="42" width="28" height="8" rx="4" fill="#F5E7D3"/>
                        </g>
                        <circle cx="150" cy="55" r="6" fill="#7F9457" opacity="0.85"/>
                        <circle cx="40" cy="150" r="5" fill="#CC6B45" opacity="0.85"/>
                    </svg>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                <div class="md:col-span-1 space-y-6">
                    <div class="glass-card p-6 rounded-2xl shadow-sm">
                        <h3 class="text-md font-bold text-stone-800 dark:text-stone-200 mb-4">{{ __('Tambah Dompet Baru') }}</h3>

                        <form method="POST" action="{{ route('wallets.store') }}" class="space-y-4">
                            @csrf
                            <div>
                                <label for="name" class="block text-sm font-semibold text-stone-700 dark:text-stone-300">{{ __('Nama Dompet') }}</label>
                                <input type="text" name="name" id="name" required placeholder="misal: Tunai / BCA / GoPay"
                                       class="mt-1 block w-full rounded-lg border-clay-200 dark:border-stone-700 dark:bg-stone-900/60 dark:text-stone-300 focus:border-clay-500 focus:ring-clay-500 shadow-sm text-sm">
                                @error('name') <p class="mt-1 text-sm text-blush-500 font-semibold">{{ $message }}</p> @enderror
                            </div>

                            <button type="submit"
                                    class="w-full rounded-full bg-clay-500 px-4 py-2 text-sm font-bold text-white hover:bg-clay-600 transition-all duration-300 transform hover:scale-[1.02] active:scale-95 shadow-sm glow-clay">
                                {{ __('+ Simpan Dompet') }}
                            </button>
                        </form>
                    </div>

                    <!-- Limit Anggaran Bulanan Card -->
                    <div class="glass-card p-6 rounded-2xl shadow-sm border-blush-500/20 glow-blush">
                        <div class="flex items-center justify-between mb-3">
                            <h3 class="text-md font-bold text-stone-800 dark:text-stone-200 flex items-center gap-1.5">
                                {{ __('Limit Anggaran 🎯') }}
                            </h3>
                            <button onclick="editBudgetLimit()" class="text-xs font-bold text-clay-600 dark:text-clay-400 hover:underline">
                                {{ __('Edit') }}
                            </button>
                        </div>
                        <div class="space-y-3">
                            <div>
                                <span class="text-xs text-stone-500 dark:text-stone-400">{{ __('Total Belanja Bulan Ini:') }}</span>
                                <p class="text-lg font-extrabold text-stone-900 dark:text-white" id="budget-spent-text">
                                    Rp {{ number_format(auth()->user()->transactions()->where('type', 'expense')->whereMonth('date', now()->month)->whereYear('date', now()->year)->sum('amount'), 0, ',', '.') }}
                                </p>
                            </div>
                            <div>
                                <div class="flex justify-between text-xs font-semibold text-stone-500 dark:text-stone-400 mb-1">
                                    <span id="budget-percentage">0% {{ __('terpakai') }}</span>
                                    <span id="budget-limit-text">{{ __('Limit') }}: Rp 5.000.000</span>
                                </div>
                                <div class="w-full bg-stone-200 dark:bg-stone-800 rounded-full h-2 overflow-hidden">
                                    <div id="budget-progress-bar" class="bg-blush-500 h-full rounded-full transition-all duration-500" style="width: 0%"></div>
                                </div>
                            </div>
                            <p class="text-[11px]" id="budget-status-message"></p>
                        </div>
                    </div>
                </div>

                <!-- Daftar Dompet (2 Columns) -->
                <div class="md:col-span-2">
                    <div class="glass-card p-6 rounded-2xl shadow-sm">
                        <h3 class="text-md font-bold text-stone-800 dark:text-stone-200 mb-4">{{ __('Daftar Dompet Anda') }}</h3>

                        @if ($wallets->isEmpty())
                            <div class="text-center py-10 text-stone-400 dark:text-stone-500">
                                <svg class="w-12 h-12 mx-auto mb-2 text-stone-300 dark:text-stone-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 10a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1h-4a1 1 0 01-1-1v-4z"/>
                                </svg>
                                <p class="text-sm">{{ __('Belum ada dompet terdaftar. Tambah dompet baru untuk mengkategorikan uang Anda!') }}</p>
                            </div>
                        @else
                            <div class="overflow-hidden border border-clay-100 dark:border-stone-800/60 rounded-xl">
                                <table class="w-full text-left text-sm">
                                    <thead class="bg-clay-500/5 text-stone-600 dark:text-stone-300 border-b border-clay-100 dark:border-stone-800/60">
                                        <tr>
                                            <th class="px-6 py-4 font-bold uppercase tracking-wider text-xs">{{ __('Nama Dompet') }}</th>
                                            <th class="px-6 py-4 font-bold uppercase tracking-wider text-xs text-center">{{ __('Jumlah Transaksi') }}</th>
                                            <th class="px-6 py-4 font-bold uppercase tracking-wider text-xs text-center">{{ __('Aksi') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-clay-100 dark:divide-stone-800/60">
                                        @foreach ($wallets as $wallet)
                                            <tr class="text-stone-700 dark:text-stone-300 hover:bg-clay-500/5 transition-colors">
                                                <td class="px-6 py-4 font-semibold text-stone-900 dark:text-white">{{ $wallet->name }}</td>
                                                <td class="px-6 py-4 text-center font-medium">{{ $wallet->transactions_count }}</td>
                                                <td class="px-6 py-4 text-center">
                                                    <form action="{{ route('wallets.destroy', $wallet) }}" method="POST"
                                                          onsubmit="event.preventDefault(); confirmAction(this, '{{ __('Apakah Anda yakin ingin menghapus dompet ini? Transaksi di dalamnya tidak akan dihapus, namun kolom dompetnya akan dikosongkan.') }}');"
                                                          class="inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                                class="text-blush-600 hover:text-blush-800 dark:text-blush-400 dark:hover:text-blush-300 transition-colors"
                                                                title="Hapus Dompet">
                                                            <svg class="h-5 w-5 mx-auto" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                            </svg>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif

                    </div>
                </div>

            </div>

        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            updateBudgetUI();
        });

        function getBudgetLimit() {
            const stored = localStorage.getItem('monthly_budget_limit');
            return stored ? parseInt(stored) : 5000000; // Default 5 million
        }

        function updateBudgetUI() {
            const limit = getBudgetLimit();
            const spent = {{ auth()->user()->transactions()->where('type', 'expense')->whereMonth('date', now()->month)->whereYear('date', now()->year)->sum('amount') }};
            const percentage = Math.min(Math.round((spent / limit) * 100), 100);

            document.getElementById('budget-limit-text').innerText = '{{ __('Limit') }}: ' + formatRupiah(limit);
            document.getElementById('budget-percentage').innerText = percentage + '% {{ __('terpakai') }}';
            
            const progressBar = document.getElementById('budget-progress-bar');
            progressBar.style.width = percentage + '%';

            const statusMsg = document.getElementById('budget-status-message');
            if (percentage >= 100) {
                progressBar.className = 'bg-blush-600 h-full rounded-full transition-all duration-500';
                statusMsg.innerText = '⚠️ {{ __('Waduh, anggaran kamu sudah boncos!') }}';
                statusMsg.className = 'text-[11px] text-blush-600 dark:text-blush-400 font-bold';
            } else if (percentage >= 80) {
                progressBar.className = 'bg-clay-400 h-full rounded-full transition-all duration-500';
                statusMsg.innerText = '⚠️ {{ __('Hati-hati, sudah mendekati limit!') }}';
                statusMsg.className = 'text-[11px] text-clay-500 dark:text-clay-400 font-semibold';
            } else {
                progressBar.className = 'bg-blush-500 h-full rounded-full transition-all duration-500';
                statusMsg.innerText = '👍 {{ __('Pengeluaran kamu masih terpantau aman.') }}';
                statusMsg.className = 'text-[11px] text-sage-600 dark:text-sage-400 font-semibold';
            }
        }

        function editBudgetLimit() {
            const currentLimit = getBudgetLimit();
            const newLimitStr = prompt('{{ __('Masukkan limit anggaran bulanan baru (Rp):') }}', currentLimit);
            if (newLimitStr !== null) {
                const newLimit = parseInt(newLimitStr.replace(/\D/g, ''));
                if (!isNaN(newLimit) && newLimit > 0) {
                    localStorage.setItem('monthly_budget_limit', newLimit);
                    updateBudgetUI();
                    showToast('{{ __('Limit anggaran bulanan berhasil diperbarui!') }}', 'success');
                } else {
                    showToast('{{ __('Masukkan angka limit yang valid!') }}', 'error');
                }
            }
        }

        function formatRupiah(number) {
            return 'Rp ' + new Intl.NumberFormat('id-ID').format(number);
        }
    </script>
    @endpush
</x-app-layout>
