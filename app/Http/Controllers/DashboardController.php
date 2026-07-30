<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        
        $month = $request->input('month', Carbon::now()->month);
        $year = $request->input('year', Carbon::now()->year);
        $date = Carbon::createFromDate($year, $month, 1);

        $startOfMonth = $date->copy()->startOfMonth();
        $endOfMonth = $date->copy()->endOfMonth();

        // Total Pemasukan bulan terpilh
        $totalIncome = $user->transactions()
            ->where('type', 'income')
            ->whereBetween('date', [$startOfMonth, $endOfMonth])
            ->sum('amount');

        // Total Pengeluaran bulan terpilih
        $totalExpense = $user->transactions()
            ->where('type', 'expense')
            ->whereBetween('date', [$startOfMonth, $endOfMonth])
            ->sum('amount');

        // Saldo bersih (seluruh waktu) untuk mencerminkan total uang riil yang dimiliki
        $allTimeIncome = $user->transactions()->where('type', 'income')->sum('amount');
        $allTimeExpense = $user->transactions()->where('type', 'expense')->sum('amount');
        $netBalance = $allTimeIncome - $allTimeExpense;

        // 5 Transaksi terbaru (Eager load category & wallet untuk cegah N+1)
        $recentTransactions = $user->transactions()
            ->with(['category', 'wallet'])
            ->latest('date')
            ->latest('id')
            ->take(5)
            ->get();

        // Rincian Pengeluaran berdasarkan Kategori (bulan terpilh)
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

        $availableYears = range(Carbon::now()->year - 4, Carbon::now()->year + 1);
        $availableMonths = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus', 
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];

        return view('dashboard', compact(
            'totalIncome', 
            'totalExpense', 
            'netBalance', 
            'recentTransactions', 
            'expenseByCategory', 
            'month', 
            'year', 
            'availableMonths', 
            'availableYears'
        ));
    }
}
