<x-app-layout>
    <x-slot name="title">{{ __('Transaksi') }}</x-slot>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-bold text-stone-800 dark:text-stone-200">{{ __('Daftar Transaksi') }}</h2>
            <div class="flex items-center gap-3">
                <a href="{{ route('transactions.export.csv', request()->query()) }}"
                   class="rounded-full bg-sage-500/90 px-4 py-2 text-sm font-bold text-white hover:bg-sage-600 shadow-sm transition-all duration-200 transform hover:scale-[1.02] active:scale-95"
                   title="{{ __('Ekspor CSV') }}">
                   {{ __('Ekspor CSV') }}
                </a>
                <a href="{{ route('transactions.export.pdf', request()->query()) }}"
                   class="rounded-full bg-blush-500/90 px-4 py-2 text-sm font-bold text-white hover:bg-blush-600 shadow-sm transition-all duration-200 transform hover:scale-[1.02] active:scale-95"
                   title="{{ __('Ekspor PDF') }}">
                   {{ __('Ekspor PDF') }}
                </a>
                <button onclick="openCreateModal()"
                   class="rounded-full bg-clay-500 px-4 py-2 text-sm font-bold text-white hover:bg-clay-600 shadow-md transition-all duration-300 transform hover:scale-[1.02] active:scale-95 glow-clay">
                    {{ __('+ Tambah Transaksi') }}
                </button>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-screen-xl px-4 sm:px-6 lg:px-10">

            <!-- Header Banner (Gen-Z Style) -->
            <div class="relative overflow-hidden glass-card p-6 rounded-3xl mb-8 flex flex-col md:flex-row items-center justify-between gap-6 border-clay-500/10 glow-clay">
                <div class="z-10 text-center md:text-left col-span-2">
                    <h1 class="text-2xl font-extrabold text-stone-900 dark:text-white leading-tight">
                        {{ __('Catatan Arus Kas Kamu 💸') }}
                    </h1>
                    <p class="text-stone-500 dark:text-stone-400 text-sm mt-1 max-w-md">
                        {{ __('Semua riwayat pengeluaran dan pemasukan kamu terkumpul di sini. Saring berdasarkan dompet, kategori, atau tanggal!') }}
                    </p>
                </div>
                <!-- Decorative illustration -->
                <div class="flex-shrink-0 relative w-28 h-28 md:w-32 md:h-32 float-animation">
                    <svg viewBox="0 0 200 200" class="w-full h-full">
                        <defs>
                            <linearGradient id="trxBlobGrad" x1="0%" y1="0%" x2="100%" y2="100%">
                                <stop offset="0%" stop-color="#F3C7CE" />
                                <stop offset="100%" stop-color="#F5CDBC" />
                            </linearGradient>
                        </defs>
                        <path fill="url(#trxBlobGrad)" opacity="0.9" d="M44.5,-53.2C56.9,-43.6,65.6,-28.9,68.4,-13C71.2,3,68.1,20.1,58.9,33.6C49.7,47.1,34.4,57,17.8,62.5C1.2,68,-16.7,69.1,-31.9,63C-47.1,56.9,-59.6,43.6,-66.1,27.6C-72.6,11.6,-73.1,-7.1,-66.6,-22.5C-60.1,-37.9,-46.6,-50,-32,-58.7C-17.4,-67.4,-1.7,-72.7,12.8,-70.8C27.3,-68.9,32.1,-62.8,44.5,-53.2Z" transform="translate(100 100)" />
                        <g transform="translate(66 58)">
                            <rect x="0" y="0" width="60" height="84" rx="8" fill="#FFFDF9" stroke="#A84457" stroke-width="3"/>
                            <path d="M8 18 H52 M8 34 H52 M8 50 H38" stroke="#A84457" stroke-width="3" stroke-linecap="round"/>
                            <circle cx="46" cy="66" r="9" fill="#9AAC70"/>
                            <path d="M42 66 l3 3 l6 -7" stroke="#FFFDF9" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"/>
                        </g>
                    </svg>
                </div>
            </div>

            <!-- Filter Form Section (Glassmorphic) -->
            <div class="glass-card p-5 rounded-2xl shadow-sm mb-6">
                <form method="GET" action="{{ route('transactions.index') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-7 gap-4 items-end">

                    <!-- Search Input -->
                    <div>
                        <label for="search" class="block text-xs font-bold text-stone-500 dark:text-stone-400 uppercase tracking-wider mb-1">{{ __('Cari Transaksi') }}</label>
                        <input type="text" name="search" id="search" value="{{ request('search') }}" placeholder="{{ __('Judul / catatan...') }}"
                               class="rounded-lg border-clay-200 dark:border-stone-700 dark:bg-stone-900/60 dark:text-stone-300 focus:border-clay-500 focus:ring-clay-500 shadow-sm w-full text-sm">
                    </div>

                    <!-- Type Selector -->
                    <div>
                        <label for="type" class="block text-xs font-bold text-stone-500 dark:text-stone-400 uppercase tracking-wider mb-1">{{ __('Tipe') }}</label>
                        <select name="type" id="type"
                                class="rounded-lg border-clay-200 dark:border-stone-700 dark:bg-stone-900/60 dark:text-stone-300 focus:border-clay-500 focus:ring-clay-500 shadow-sm w-full text-sm">
                            <option value="">{{ __('Semua Tipe') }}</option>
                            <option value="income" {{ request('type') === 'income' ? 'selected' : '' }}>{{ __('Pemasukan') }}</option>
                            <option value="expense" {{ request('type') === 'expense' ? 'selected' : '' }}>{{ __('Pengeluaran') }}</option>
                        </select>
                    </div>

                    <!-- Wallet Selector -->
                    <div>
                        <label for="wallet_id" class="block text-xs font-bold text-stone-500 dark:text-stone-400 uppercase tracking-wider mb-1">{{ __('Dompet') }}</label>
                        <select name="wallet_id" id="wallet_id"
                                class="rounded-lg border-clay-200 dark:border-stone-700 dark:bg-stone-900/60 dark:text-stone-300 focus:border-clay-500 focus:ring-clay-500 shadow-sm w-full text-sm">
                            <option value="">{{ __('Semua Dompet') }}</option>
                            @foreach($wallets as $wallet)
                                <option value="{{ $wallet->id }}" {{ request('wallet_id') == $wallet->id ? 'selected' : '' }}>
                                    {{ $wallet->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Category Selector -->
                    <div>
                        <label for="category_id" class="block text-xs font-bold text-stone-500 dark:text-stone-400 uppercase tracking-wider mb-1">{{ __('Kategori') }}</label>
                        <select name="category_id" id="category_id"
                                class="rounded-lg border-clay-200 dark:border-stone-700 dark:bg-stone-900/60 dark:text-stone-300 focus:border-clay-500 focus:ring-clay-500 shadow-sm w-full text-sm">
                            <option value="">{{ __('Semua Kategori') }}</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }} ({{ $category->type === 'income' ? __('Masuk') : __('Keluar') }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Start Date -->
                    <div>
                        <label for="start_date" class="block text-xs font-bold text-stone-500 dark:text-stone-400 uppercase tracking-wider mb-1">{{ __('Mulai Tanggal') }}</label>
                        <input type="date" name="start_date" id="start_date" value="{{ request('start_date') }}"
                               class="rounded-lg border-clay-200 dark:border-stone-700 dark:bg-stone-900/60 dark:text-stone-300 focus:border-clay-500 focus:ring-clay-500 shadow-sm w-full text-sm">
                    </div>

                    <!-- End Date -->
                    <div>
                        <label for="end_date" class="block text-xs font-bold text-stone-500 dark:text-stone-400 uppercase tracking-wider mb-1">{{ __('Sampai Tanggal') }}</label>
                        <input type="date" name="end_date" id="end_date" value="{{ request('end_date') }}"
                               class="rounded-lg border-clay-200 dark:border-stone-700 dark:bg-stone-900/60 dark:text-stone-300 focus:border-clay-500 focus:ring-clay-500 shadow-sm w-full text-sm">
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex gap-2">
                        <button type="submit"
                                class="flex-1 rounded-lg bg-clay-500 px-4 py-2 text-sm font-bold text-white hover:bg-clay-600 transition-colors shadow-sm focus:outline-none">
                            {{ __('Filter') }}
                        </button>
                        @if(request()->anyFilled(['search', 'type', 'wallet_id', 'category_id', 'start_date', 'end_date']))
                            <a href="{{ route('transactions.index') }}"
                               class="rounded-lg bg-stone-100 hover:bg-stone-200 dark:bg-stone-800 dark:hover:bg-stone-700 px-4 py-2 text-sm font-bold text-stone-700 dark:text-stone-300 transition-colors shadow-sm text-center">
                                {{ __('Reset') }}
                            </a>
                        @endif
                    </div>

                </form>
            </div>

            <!-- Table Container (Glassmorphic) -->
            <div class="overflow-hidden glass-card shadow-sm sm:rounded-2xl">
                @if ($transactions->isEmpty())
                    @if(request()->anyFilled(['search', 'type', 'wallet_id', 'category_id', 'start_date', 'end_date']))
                        <p class="p-8 text-center text-stone-500 dark:text-stone-400">{{ __('Tidak ada transaksi yang cocok dengan filter pencarian.') }}</p>
                    @else
                        <p class="p-8 text-center text-stone-500 dark:text-stone-400">{{ __('Belum ada transaksi. Yuk catat pengeluaran pertama!') }}</p>
                    @endif
                @else
                    <table class="w-full text-left text-sm">
                        <thead class="bg-clay-500/5 text-stone-600 dark:text-stone-300 border-b border-clay-100 dark:border-stone-800/60">
                            <tr>
                                <th class="px-6 py-4 font-bold uppercase tracking-wider text-xs">{{ __('Tanggal') }}</th>
                                <th class="px-6 py-4 font-bold uppercase tracking-wider text-xs">{{ __('Judul') }}</th>
                                <th class="px-6 py-4 font-bold uppercase tracking-wider text-xs">{{ __('Tipe') }}</th>
                                <th class="px-6 py-4 font-bold uppercase tracking-wider text-xs">{{ __('Dompet') }}</th>
                                <th class="px-6 py-4 font-bold uppercase tracking-wider text-xs">{{ __('Kategori') }}</th>
                                <th class="px-6 py-4 font-bold uppercase tracking-wider text-xs text-right">{{ __('Jumlah (Rp)') }}</th>
                                <th class="px-6 py-4 font-bold uppercase tracking-wider text-xs text-center">{{ __('Aksi') }}</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-clay-100 dark:divide-stone-800/60">
                            @foreach ($transactions as $trx)
                                <tr class="text-stone-700 dark:text-stone-300 hover:bg-clay-500/5 transition-colors duration-150">
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $trx->date->format('d M Y') }}</td>
                                    <td class="px-6 py-4">
                                        <div class="font-semibold text-stone-900 dark:text-white">{{ $trx->title }}</div>
                                        @if($trx->description)
                                            <div class="text-xs text-stone-400 dark:text-stone-500 mt-0.5 max-w-xs truncate">{{ $trx->description }}</div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        @if ($trx->type === 'income')
                                            <span class="rounded-md bg-sage-500/10 px-2.5 py-1 text-xs font-bold text-sage-600 dark:text-sage-400">{{ __('Pemasukan') }}</span>
                                        @else
                                            <span class="rounded-md bg-blush-500/10 px-2.5 py-1 text-xs font-bold text-blush-600 dark:text-blush-400">{{ __('Pengeluaran') }}</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="text-sm font-medium text-stone-600 dark:text-stone-400">
                                            {{ $trx->wallet ? $trx->wallet->name : __('Tanpa Dompet') }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($trx->category)
                                            <span class="inline-block text-[11px] font-bold px-2.5 py-0.5 rounded-md" style="background-color: {{ $trx->category->color }}15; color: {{ $trx->category->color }};">
                                                {{ $trx->category->name }}
                                            </span>
                                        @else
                                            <span class="text-sm text-stone-400 dark:text-stone-500">-</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-right font-bold {{ $trx->type === 'income' ? 'text-sage-600 dark:text-sage-400' : 'text-blush-600 dark:text-blush-400' }} whitespace-nowrap">
                                        {{ $trx->type === 'income' ? '+' : '-' }} Rp {{ number_format($trx->amount, 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <div class="flex items-center justify-center gap-3">
                                            <!-- Edit button with serialized data -->
                                            <button onclick="openEditModal({{ json_encode([
                                                'id' => $trx->id,
                                                'wallet_id' => $trx->wallet_id,
                                                'category_id' => $trx->category_id,
                                                'type' => $trx->type,
                                                'title' => $trx->title,
                                                'amount' => $trx->amount,
                                                'date' => $trx->date->format('Y-m-d'),
                                                'description' => $trx->description
                                            ]) }})"
                                               class="text-clay-600 hover:text-clay-800 dark:text-clay-400 dark:hover:text-clay-300 transition-colors"
                                               title="Ubah">
                                                <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                </svg>
                                            </button>
                                            <form action="{{ route('transactions.destroy', $trx) }}" method="POST"
                                                  onsubmit="event.preventDefault(); confirmAction(this, 'Apakah Anda yakin ingin menghapus transaksi ini?');"
                                                  class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="text-blush-600 hover:text-blush-800 dark:text-blush-400 dark:hover:text-blush-300 transition-colors"
                                                        title="Hapus">
                                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>

    <!-- Unified Glassmorphic Pop-up Modal Form -->
    <div id="transactionModal" class="fixed inset-0 z-50 overflow-y-auto hidden">
        <!-- Backdrop -->
        <div class="fixed inset-0 bg-stone-950/40 backdrop-blur-sm transition-opacity" onclick="closeModal()"></div>

        <!-- Modal Wrapper -->
        <div class="flex min-h-screen items-center justify-center p-4">
            <div class="relative w-full max-w-lg glass-modal p-6 rounded-2xl transform transition-all scale-95 opacity-0 duration-300 ease-out z-10" id="modalBox">

                <!-- Close Button -->
                <button class="absolute top-4 right-4 text-stone-400 hover:text-stone-600 dark:hover:text-white transition-colors" onclick="closeModal()">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>

                <h3 class="text-lg font-bold text-stone-900 dark:text-white mb-6" id="modalTitle">{{ __('Tambah Transaksi') }}</h3>

                <form id="transactionForm" method="POST" class="space-y-4">
                    @csrf
                    <!-- Method Spoofing and Mode Indicators -->
                    <input type="hidden" id="formMethod" name="_method" value="POST">
                    <input type="hidden" id="isEdit" name="is_edit" value="0">
                    <input type="hidden" id="transactionId" name="transaction_id" value="">

                    <!-- Type Selector -->
                    <div>
                        <label for="modal_type" class="block text-sm font-bold text-stone-700 dark:text-stone-300">{{ __('Tipe') }}</label>
                        <select name="type" id="modal_type" class="mt-1 block w-full rounded-lg border-clay-200 dark:border-stone-700 dark:bg-stone-900/60 dark:text-stone-200">
                            <option value="expense" {{ old('type') === 'expense' ? 'selected' : '' }}>{{ __('Pengeluaran') }}</option>
                            <option value="income" {{ old('type') === 'income' ? 'selected' : '' }}>{{ __('Pemasukan') }}</option>
                        </select>
                        @error('type') <p class="mt-1 text-sm text-blush-500 font-semibold">{{ $message }}</p> @enderror
                    </div>

                    <!-- Wallet Selector -->
                    <div>
                        <label for="modal_wallet_id" class="block text-sm font-bold text-stone-700 dark:text-stone-300">{{ __('Dompet (Wallet)') }}</label>
                        <select name="wallet_id" id="modal_wallet_id" class="mt-1 block w-full rounded-lg border-clay-200 dark:border-stone-700 dark:bg-stone-900/60 dark:text-stone-200">
                            @foreach($wallets as $wallet)
                                <option value="{{ $wallet->id }}" {{ old('wallet_id') == $wallet->id ? 'selected' : '' }}>
                                    {{ $wallet->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('wallet_id') <p class="mt-1 text-sm text-blush-500 font-semibold">{{ $message }}</p> @enderror
                    </div>

                    <!-- Category Selector (Dynamic) -->
                    <div>
                        <label for="modal_category_id" class="block text-sm font-bold text-stone-700 dark:text-stone-300">{{ __('Kategori') }}</label>
                        <select name="category_id" id="modal_category_id" class="mt-1 block w-full rounded-lg border-clay-200 dark:border-stone-700 dark:bg-stone-900/60 dark:text-stone-200">
                            <option value="" data-type="all">{{ __('Pilih Kategori') }} ({{ __('opsional') }})</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" data-type="{{ $category->type }}">
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id') <p class="mt-1 text-sm text-blush-500 font-semibold">{{ $message }}</p> @enderror
                    </div>

                    <!-- Title -->
                    <div>
                        <label for="modal_title" class="block text-sm font-bold text-stone-700 dark:text-stone-300">{{ __('Judul') }}</label>
                        <input type="text" name="title" id="modal_title" value="{{ old('title') }}" placeholder="{{ __('misal: Makan siang / Gaji bulanan') }}"
                               class="mt-1 block w-full rounded-lg border-clay-200 dark:border-stone-700 dark:bg-stone-900/60 dark:text-stone-200">
                        @error('title') <p class="mt-1 text-sm text-blush-500 font-semibold">{{ $message }}</p> @enderror
                    </div>

                    <!-- Amount -->
                    <div>
                        <label for="modal_amount" class="block text-sm font-bold text-stone-700 dark:text-stone-300">{{ __('Jumlah (Rp)') }}</label>
                        <input type="number" name="amount" id="modal_amount" value="{{ old('amount') }}" placeholder="misal: 50000"
                               class="mt-1 block w-full rounded-lg border-clay-200 dark:border-stone-700 dark:bg-stone-900/60 dark:text-stone-200">
                        @error('amount') <p class="mt-1 text-sm text-blush-500 font-semibold">{{ $message }}</p> @enderror
                    </div>

                    <!-- Date -->
                    <div>
                        <label for="modal_date" class="block text-sm font-bold text-stone-700 dark:text-stone-300">{{ __('Tanggal') }}</label>
                        <input type="date" name="date" id="modal_date" value="{{ old('date', date('Y-m-d')) }}"
                               class="mt-1 block w-full rounded-lg border-clay-200 dark:border-stone-700 dark:bg-stone-900/60 dark:text-stone-200">
                        @error('date') <p class="mt-1 text-sm text-blush-500 font-semibold">{{ $message }}</p> @enderror
                    </div>

                    <!-- Description -->
                    <div>
                        <label for="modal_description" class="block text-sm font-bold text-stone-700 dark:text-stone-300">{{ __('Deskripsi') }}</label>
                        <textarea name="description" id="modal_description" rows="3" placeholder="{{ __('Tulis catatan di sini (opsional)...') }}"
                                  class="mt-1 block w-full rounded-lg border-clay-200 dark:border-stone-700 dark:bg-stone-900/60 dark:text-stone-200">{{ old('description') }}</textarea>
                        @error('description') <p class="mt-1 text-sm text-blush-500 font-semibold">{{ $message }}</p> @enderror
                    </div>

                    <!-- Submit Buttons -->
                    <div class="flex justify-end gap-3 pt-4">
                        <button type="button" onclick="closeModal()"
                                class="rounded-full bg-stone-100 hover:bg-stone-200 dark:bg-stone-800 dark:hover:bg-stone-700 px-4 py-2 text-sm font-bold text-stone-700 dark:text-stone-300 transition-colors">
                            {{ __('Batal') }}
                        </button>
                        <button type="submit"
                                class="rounded-full bg-clay-500 px-5 py-2 text-sm font-bold text-white hover:bg-clay-600 shadow-sm transition-colors glow-clay">
                            {{ __('Simpan') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        // DOM Elements
        const modal = document.getElementById('transactionModal');
        const modalBox = document.getElementById('modalBox');
        const form = document.getElementById('transactionForm');
        const formMethod = document.getElementById('formMethod');
        const isEdit = document.getElementById('isEdit');
        const transactionId = document.getElementById('transactionId');
        const modalTitle = document.getElementById('modalTitle');

        const typeSelect = document.getElementById('modal_type');
        const categorySelect = document.getElementById('modal_category_id');
        const categoryOptions = Array.from(categorySelect.options);

        // Open modal if redirected from FAB on other pages
        document.addEventListener('DOMContentLoaded', () => {
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.get('create') === '1') {
                openCreateModal();
            }
        });

        // Dynamic category filter based on selected type
        function filterCategories(selectedValue = '') {
            const selectedType = typeSelect.value;
            categorySelect.innerHTML = '';

            categoryOptions.forEach(option => {
                const optType = option.getAttribute('data-type');
                if (optType === 'all' || optType === selectedType) {
                    categorySelect.appendChild(option);
                }
            });

            if (selectedValue) {
                categorySelect.value = selectedValue;
            }
        }

        // Trigger category filtering when type select changes
        typeSelect.addEventListener('change', () => {
            filterCategories();
            categorySelect.value = '';
        });

        // Open Create Modal
        function openCreateModal() {
            modalTitle.innerText = "{{ __('Tambah Transaksi Baru') }}";
            form.action = "{{ route('transactions.store') }}";
            formMethod.value = "POST";
            isEdit.value = "0";
            transactionId.value = "";

            // Reset inputs
            form.reset();
            document.getElementById('modal_date').value = new Date().toISOString().substring(0, 10);

            filterCategories();

            // Display Modal
            modal.classList.remove('hidden');
            setTimeout(() => {
                modalBox.classList.remove('scale-95', 'opacity-0');
            }, 10);
        }

        // Open Edit Modal
        function openEditModal(trx) {
            modalTitle.innerText = "{{ __('Ubah Transaksi') }}";
            form.action = `/transactions/${trx.id}`;
            formMethod.value = "PUT";
            isEdit.value = "1";
            transactionId.value = trx.id;

            // Fill inputs
            typeSelect.value = trx.type;
            document.getElementById('modal_wallet_id').value = trx.wallet_id || '';
            document.getElementById('modal_title').value = trx.title;
            document.getElementById('modal_amount').value = Math.floor(trx.amount);
            document.getElementById('modal_date').value = trx.date;
            document.getElementById('modal_description').value = trx.description || '';

            // Filter and select Category
            filterCategories(trx.category_id || '');

            // Display Modal
            modal.classList.remove('hidden');
            setTimeout(() => {
                modalBox.classList.remove('scale-95', 'opacity-0');
            }, 10);
        }

        // Close Modal with smooth scaling transition
        function closeModal() {
            modalBox.classList.add('scale-95', 'opacity-0');
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 250);
        }

        // Auto-reopen modal if there are Laravel validation errors on redirect
        @if ($errors->any())
            window.addEventListener('DOMContentLoaded', () => {
                const mode = "{{ old('is_edit') }}";
                if (mode === "1") {
                    // Reopen Edit mode modal with old input values
                    openEditModal({
                        id: "{{ old('transaction_id') }}",
                        type: "{{ old('type') }}",
                        wallet_id: "{{ old('wallet_id') }}",
                        category_id: "{{ old('category_id') }}",
                        title: "{{ old('title') }}",
                        amount: "{{ old('amount') }}",
                        date: "{{ old('date') }}",
                        description: "{{ old('description') }}"
                    });
                } else {
                    // Reopen Create mode modal with old input values
                    openCreateModal();
                    // Restore inputs manually after reset
                    typeSelect.value = "{{ old('type', 'expense') }}";
                    document.getElementById('modal_wallet_id').value = "{{ old('wallet_id') }}";
                    document.getElementById('modal_title').value = "{{ old('title') }}";
                    document.getElementById('modal_amount').value = "{{ old('amount') }}";
                    document.getElementById('modal_date').value = "{{ old('date') }}";
                    document.getElementById('modal_description').value = "{{ old('description') }}";
                    filterCategories("{{ old('category_id') }}");
                }
            });
        @endif
    </script>
    @endpush
</x-app-layout>
