<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    // Halaman daftar transaksi dengan pencarian & filter
    public function index(Request $request)
    {
        $query = auth()->user()->transactions()->with(['wallet', 'category']);

        // Filter Pencarian (Judul / Catatan)
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Filter Tipe (Pemasukan / Pengeluaran)
        if ($request->filled('type')) {
            $query->where('type', $request->input('type'));
        }

        // Filter Dompet (Wallet)
        if ($request->filled('wallet_id')) {
            $query->where('wallet_id', $request->input('wallet_id'));
        }

        // Filter Kategori (Category)
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->input('category_id'));
        }

        // Filter Tanggal Mulai
        if ($request->filled('start_date')) {
            $query->whereDate('date', '>=', $request->input('start_date'));
        }

        // Filter Tanggal Selesai
        if ($request->filled('end_date')) {
            $query->whereDate('date', '<=', $request->input('end_date'));
        }

        $transactions = $query->latest('date')->latest('id')->get();
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
            'wallet_id'   => 'nullable|exists:wallets,id,user_id,' . auth()->id(),
            'category_id' => 'nullable|exists:categories,id,user_id,' . auth()->id(),
            'type'        => 'required|in:income,expense',
            'title'       => 'required|string|max:255',
            'amount'      => 'required|numeric|min:0',
            'date'        => 'required|date',
            'description' => 'nullable|string',
        ]);

        // Otomatis nempel ke user yang lagi login
        auth()->user()->transactions()->create($validated);

        return redirect()->route('transactions.index')
            ->with('success', 'Transaksi berhasil ditambahkan!');
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
            'wallet_id'   => 'nullable|exists:wallets,id,user_id,' . auth()->id(),
            'category_id' => 'nullable|exists:categories,id,user_id,' . auth()->id(),
            'type'        => 'required|in:income,expense',
            'title'       => 'required|string|max:255',
            'amount'      => 'required|numeric|min:0',
            'date'        => 'required|date',
            'description' => 'nullable|string',
        ]);

        $transaction->update($validated);

        return redirect()->route('transactions.index')
            ->with('success', 'Transaksi berhasil diperbarui!');
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
        $query = auth()->user()->transactions()->with(['wallet', 'category']);

        // Terapkan filter yang sama
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }
        if ($request->filled('type')) {
            $query->where('type', $request->input('type'));
        }
        if ($request->filled('wallet_id')) {
            $query->where('wallet_id', $request->input('wallet_id'));
        }
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->input('category_id'));
        }
        if ($request->filled('start_date')) {
            $query->whereDate('date', '>=', $request->input('start_date'));
        }
        if ($request->filled('end_date')) {
            $query->whereDate('date', '<=', $request->input('end_date'));
        }

        $transactions = $query->latest('date')->latest('id')->get();

        $callback = function() use ($transactions) {
            $file = fopen('php://output', 'w');
            // Menulis header CSV
            fputcsv($file, ['Tanggal', 'Judul', 'Tipe', 'Dompet', 'Kategori', 'Jumlah (Rp)', 'Catatan']);

            foreach ($transactions as $trx) {
                fputcsv($file, [
                    $trx->date->format('Y-m-d'),
                    $trx->title,
                    $trx->type === 'income' ? 'Pemasukan' : 'Pengeluaran',
                    $trx->wallet ? $trx->wallet->name : 'Tanpa Dompet',
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
        $query = auth()->user()->transactions()->with(['wallet', 'category']);

        // Terapkan filter yang sama
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }
        if ($request->filled('type')) {
            $query->where('type', $request->input('type'));
        }
        if ($request->filled('wallet_id')) {
            $query->where('wallet_id', $request->input('wallet_id'));
        }
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->input('category_id'));
        }
        if ($request->filled('start_date')) {
            $query->whereDate('date', '>=', $request->input('start_date'));
        }
        if ($request->filled('end_date')) {
            $query->whereDate('date', '<=', $request->input('end_date'));
        }

        $transactions = $query->latest('date')->latest('id')->get();

        // Hitung ringkasan untuk laporan PDF
        $totalIncome = $transactions->where('type', 'income')->sum('amount');
        $totalExpense = $transactions->where('type', 'expense')->sum('amount');
        $netBalance = $totalIncome - $totalExpense;

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('transactions.pdf', compact('transactions', 'totalIncome', 'totalExpense', 'netBalance'));
        
        return $pdf->download('laporan-transaksi-' . date('Ymd-His') . '.pdf');
    }
}