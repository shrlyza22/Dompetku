<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    // Halaman daftar transaksi dengan pencarian & filter
    public function index(Request $request)
    {
        $transactions = auth()->user()->transactions()
            ->with(['wallet', 'targetWallet', 'category'])
            ->filter($request->all())
            ->latest('date')
            ->latest('id')
            ->paginate(15)
            ->withQueryString();

        $wallets = auth()->user()->wallets;
        $categories = auth()->user()->categories;

        return view('transactions.index', compact('transactions', 'wallets', 'categories'));
    }

    // Halaman form tambah
    public function create()
    {
        $wallets = auth()->user()->wallets;
        if ($wallets->isEmpty()) {
            auth()->user()->wallets()->create(['name' => 'Dompet Utama']);
            $wallets = auth()->user()->wallets()->get();
        }

        $categories = auth()->user()->categories;
        if ($categories->isEmpty()) {
            \App\Models\Category::seedDefaultsForUser(auth()->id());
            $categories = auth()->user()->categories()->get();
        }

        return view('transactions.create', compact('wallets', 'categories'));
    }

    // Simpan transaksi baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'wallet_id'        => 'nullable|exists:wallets,id,user_id,' . auth()->id(),
            'target_wallet_id' => 'nullable|exists:wallets,id,user_id,' . auth()->id(),
            'category_id'      => 'nullable|exists:categories,id,user_id,' . auth()->id(),
            'type'             => 'required|in:income,expense,transfer',
            'title'            => 'required|string|max:255',
            'amount'           => 'required|numeric|min:0',
            'date'             => 'required|date',
            'description'      => 'nullable|string',
        ]);

        if ($validated['type'] === 'transfer') {
            if (empty($validated['wallet_id']) || empty($validated['target_wallet_id'])) {
                return redirect()->back()
                    ->withInput()
                    ->withErrors(['target_wallet_id' => 'Dompet asal dan dompet tujuan wajib diisi untuk transfer.']);
            }
            if ($validated['wallet_id'] == $validated['target_wallet_id']) {
                return redirect()->back()
                    ->withInput()
                    ->withErrors(['target_wallet_id' => 'Dompet tujuan tidak boleh sama dengan dompet asal.']);
            }
            // Kategori dikosongkan untuk transfer agar tidak mengacaukan budget kategori pengeluaran
            $validated['category_id'] = null;
        }

        // Otomatis nempel ke user yang lagi login
        auth()->user()->transactions()->create($validated);

        return redirect()->route('transactions.index')
            ->with('success', 'Transaksi berhasil ditambahkan!')
            ->with('last_transaction_type', $validated['type']);
    }

    // Halaman form edit
    public function edit(Transaction $transaction)
    {
        // Scope pencarian hanya pada transaksi milik user aktif untuk keamanan
        $transaction = auth()->user()->transactions()->findOrFail($transaction->id);
        
        $wallets = auth()->user()->wallets;
        if ($wallets->isEmpty()) {
            auth()->user()->wallets()->create(['name' => 'Dompet Utama']);
            $wallets = auth()->user()->wallets()->get();
        }

        $categories = auth()->user()->categories;
        if ($categories->isEmpty()) {
            \App\Models\Category::seedDefaultsForUser(auth()->id());
            $categories = auth()->user()->categories()->get();
        }

        return view('transactions.edit', compact('transaction', 'wallets', 'categories'));
    }

    // Perbarui transaksi
    public function update(Request $request, Transaction $transaction)
    {
        $transaction = auth()->user()->transactions()->findOrFail($transaction->id);

        $validated = $request->validate([
            'wallet_id'        => 'nullable|exists:wallets,id,user_id,' . auth()->id(),
            'target_wallet_id' => 'nullable|exists:wallets,id,user_id,' . auth()->id(),
            'category_id'      => 'nullable|exists:categories,id,user_id,' . auth()->id(),
            'type'             => 'required|in:income,expense,transfer',
            'title'            => 'required|string|max:255',
            'amount'           => 'required|numeric|min:0',
            'date'             => 'required|date',
            'description'      => 'nullable|string',
        ]);

        if ($validated['type'] === 'transfer') {
            if (empty($validated['wallet_id']) || empty($validated['target_wallet_id'])) {
                return redirect()->back()
                    ->withInput()
                    ->withErrors(['target_wallet_id' => 'Dompet asal dan dompet tujuan wajib diisi untuk transfer.']);
            }
            if ($validated['wallet_id'] == $validated['target_wallet_id']) {
                return redirect()->back()
                    ->withInput()
                    ->withErrors(['target_wallet_id' => 'Dompet tujuan tidak boleh sama dengan dompet asal.']);
            }
            $validated['category_id'] = null;
        }

        $transaction->update($validated);

        return redirect()->route('transactions.index')
            ->with('success', 'Transaksi berhasil diperbarui!')
            ->with('last_transaction_type', $validated['type']);
    }

    // Hapus transaksi (Soft Delete)
    public function destroy(Transaction $transaction)
    {
        $transaction = auth()->user()->transactions()->findOrFail($transaction->id);
        $transaction->delete();

        return redirect()->route('transactions.index')
            ->with('success', 'Transaksi berhasil dihapus!');
    }

    // Ekspor CSV
    public function exportCsv(Request $request)
    {
        $transactions = auth()->user()->transactions()
            ->with(['wallet', 'targetWallet', 'category'])
            ->filter($request->all())
            ->latest('date')
            ->latest('id')
            ->get();

        $callback = function() use ($transactions) {
            $file = fopen('php://output', 'w');
            // Menulis header CSV
            fputcsv($file, ['Tanggal', 'Judul', 'Tipe', 'Dompet', 'Kategori', 'Jumlah (Rp)', 'Catatan']);

            foreach ($transactions as $trx) {
                $typeLabel = '';
                if ($trx->type === 'income') {
                    $typeLabel = 'Pemasukan';
                } elseif ($trx->type === 'expense') {
                    $typeLabel = 'Pengeluaran';
                } else {
                    $typeLabel = 'Transfer';
                }

                $walletLabel = '';
                if ($trx->type === 'transfer') {
                    $walletLabel = ($trx->wallet ? $trx->wallet->name : 'Tanpa Dompet') . ' -> ' . ($trx->targetWallet ? $trx->targetWallet->name : 'Tanpa Dompet');
                } else {
                    $walletLabel = $trx->wallet ? $trx->wallet->name : 'Tanpa Dompet';
                }

                fputcsv($file, [
                    $trx->date->format('Y-m-d'),
                    $trx->title,
                    $typeLabel,
                    $walletLabel,
                    $trx->category ? $trx->category->name : 'Tanpa Kategori',
                    $trx->amount,
                    $trx->description ?? ''
                ]);
            }
            fclose($file);
        };

        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=laporan-transaksi-" . date('Ymd-His') . ".csv",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        return response()->stream($callback, 200, $headers);
    }

    // Ekspor PDF
    public function exportPdf(Request $request)
    {
        $transactions = auth()->user()->transactions()
            ->with(['wallet', 'targetWallet', 'category'])
            ->filter($request->all())
            ->latest('date')
            ->latest('id')
            ->get();

        // Hitung ringkasan untuk laporan PDF
        $totalIncome = $transactions->where('type', 'income')->sum('amount');
        $totalExpense = $transactions->where('type', 'expense')->sum('amount');
        $netBalance = $totalIncome - $totalExpense;

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('transactions.pdf', compact('transactions', 'totalIncome', 'totalExpense', 'netBalance'));
        
        return $pdf->download('laporan-transaksi-' . date('Ymd-His') . '.pdf');
    }

    // Import CSV
    public function importCsv(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt|max:2048',
        ]);

        $file = $request->file('csv_file');
        $path = $file->getRealPath();
        
        $data = [];
        if (($handle = fopen($path, 'r')) !== false) {
            // Read header
            $header = fgetcsv($handle, 1000, ',');
            
            // Loop rows
            while (($row = fgetcsv($handle, 1000, ',')) !== false) {
                // Skip empty rows
                if (count($row) < 6) continue;
                $data[] = $row;
            }
            fclose($handle);
        }

        if (empty($data)) {
            return redirect()->back()->with('error', 'File CSV kosong atau tidak valid!');
        }

        $importedCount = 0;

        // Preload wallets and categories to reduce DB hits
        $wallets = auth()->user()->wallets()->pluck('id', 'name')->toArray();
        $categories = auth()->user()->categories()->pluck('id', 'name')->toArray();

        foreach ($data as $row) {
            // Mapping: 0: Tanggal, 1: Judul, 2: Tipe, 3: Dompet, 4: Kategori, 5: Jumlah, 6: Catatan
            $date = !empty($row[0]) ? trim($row[0]) : date('Y-m-d');
            $title = !empty($row[1]) ? trim($row[1]) : 'Transaksi Tanpa Judul';
            
            $rawType = !empty($row[2]) ? strtolower(trim($row[2])) : 'expense';
            $type = 'expense';
            if ($rawType === 'pemasukan' || $rawType === 'income') {
                $type = 'income';
            } elseif ($rawType === 'transfer') {
                $type = 'transfer';
            }

            $rawWallet = !empty($row[3]) ? trim($row[3]) : '';
            $walletId = null;
            $targetWalletId = null;

            if ($type === 'transfer') {
                $parts = preg_split('/\s*(?:->|➔|➔|➔)\s*/', $rawWallet);
                $sourceWalletName = !empty($parts[0]) ? trim($parts[0]) : '';
                $targetWalletName = !empty($parts[1]) ? trim($parts[1]) : '';

                if ($sourceWalletName) {
                    if (array_key_exists($sourceWalletName, $wallets)) {
                        $walletId = $wallets[$sourceWalletName];
                    } else {
                        $newWallet = auth()->user()->wallets()->create(['name' => $sourceWalletName]);
                        $wallets[$sourceWalletName] = $newWallet->id;
                        $walletId = $newWallet->id;
                    }
                }

                if ($targetWalletName) {
                    if (array_key_exists($targetWalletName, $wallets)) {
                        $targetWalletId = $wallets[$targetWalletName];
                    } else {
                        $newWallet = auth()->user()->wallets()->create(['name' => $targetWalletName]);
                        $wallets[$targetWalletName] = $newWallet->id;
                        $targetWalletId = $newWallet->id;
                    }
                }
            } else {
                if ($rawWallet) {
                    if (array_key_exists($rawWallet, $wallets)) {
                        $walletId = $wallets[$rawWallet];
                    } else {
                        $newWallet = auth()->user()->wallets()->create(['name' => $rawWallet]);
                        $wallets[$rawWallet] = $newWallet->id;
                        $walletId = $newWallet->id;
                    }
                }
            }

            $rawCategory = !empty($row[4]) ? trim($row[4]) : '';
            $categoryId = null;
            if ($type !== 'transfer' && $rawCategory && $rawCategory !== '-') {
                if (array_key_exists($rawCategory, $categories)) {
                    $categoryId = $categories[$rawCategory];
                } else {
                    $newCategory = auth()->user()->categories()->create([
                        'name' => $rawCategory,
                        'type' => $type,
                        'color' => '#' . substr(md5($rawCategory), 0, 6)
                    ]);
                    $categories[$rawCategory] = $newCategory->id;
                    $categoryId = $newCategory->id;
                }
            }

            $amount = !empty($row[5]) ? floatval(preg_replace('/[^0-9.]/', '', $row[5])) : 0;
            $description = !empty($row[6]) ? trim($row[6]) : null;

            auth()->user()->transactions()->create([
                'wallet_id'        => $walletId,
                'target_wallet_id' => $targetWalletId,
                'category_id'      => $categoryId,
                'type'             => $type,
                'title'            => $title,
                'amount'           => $amount,
                'date'             => $date,
                'description'      => $description,
            ]);

            $importedCount++;
        }

        return redirect()->route('transactions.index')
            ->with('success', "$importedCount transaksi berhasil diimport!")
            ->with('last_transaction_type', 'income');
    }
}