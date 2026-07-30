<?php

namespace App\Http\Controllers;

use App\Models\Wallet;
use Illuminate\Http\Request;

class WalletController extends Controller
{
    // Tampilkan daftar dompet
    public function index()
    {
        $wallets = auth()->user()->wallets()
            ->withCount('transactions')
            ->withSum(['transactions as total_income' => function ($query) {
                $query->where('type', 'income');
            }], 'amount')
            ->withSum(['transactions as total_expense' => function ($query) {
                $query->where('type', 'expense');
            }], 'amount')
            ->withSum(['transactions as total_transfer_out' => function ($query) {
                $query->where('type', 'transfer');
            }], 'amount')
            ->withSum(['transferInTransactions as total_transfer_in' => function ($query) {
                $query->where('type', 'transfer');
            }], 'amount')
            ->get();
        return view('wallets.index', compact('wallets'));
    }

    // Simpan dompet baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        auth()->user()->wallets()->create($validated);

        return redirect()->route('wallets.index')
            ->with('success', 'Dompet berhasil dibuat!');
    }

    // Hapus dompet
    public function destroy(Wallet $wallet)
    {
        // Pastikan dompet ini milik user yang sedang aktif
        $wallet = auth()->user()->wallets()->findOrFail($wallet->id);
        
        $wallet->delete();

        return redirect()->route('wallets.index')
            ->with('success', 'Dompet berhasil dihapus!');
    }
}
