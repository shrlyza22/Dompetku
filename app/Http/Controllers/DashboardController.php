<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();

        // Total Pemasukan bulan ini
        $totalIncome = $user->transactions()
            ->where('type', 'income')
            ->whereBetween('date', [$startOfMonth, $endOfMonth])
            ->sum('amount');

        // Total Pengeluaran bulan ini
        $totalExpense = $user->transactions()
            ->where('type', 'expense')
            ->whereBetween('date', [$startOfMonth, $endOfMonth])
            ->sum('amount');

        // Saldo bersih
        $netBalance = $totalIncome - $totalExpense;

        // 5 Transaksi terbaru
        $recentTransactions = $user->transactions()
            ->latest('date')
            ->latest('id')
            ->take(5)
            ->get();

        // Rincian Pengeluaran berdasarkan Kategori (bulan berjalan)
        $expenseByCategory = $user->transactions()
            ->where('type', 'expense')
            ->whereBetween('date', [$startOfMonth, $endOfMonth])
            ->selectRaw('category_id, sum(amount) as total')
            ->groupBy('category_id')
            ->with('category')
            ->get()
            ->map(function ($item) {
                return [
                    'name'  => $item->category ? $item->category->name : 'Tanpa Kategori',
                    'total' => (float) $item->total,
                    'color' => $item->category ? $item->category->color : '#6B7280',
                ];
            });

        return view('dashboard', compact('totalIncome', 'totalExpense', 'netBalance', 'recentTransactions', 'expenseByCategory'));
    }
}
