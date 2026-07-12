<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Transaksi Keuangan</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            font-size: 12px;
            color: #333;
            line-height: 1.4;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #e2e8f0;
            padding-bottom: 10px;
        }
        .header h2 {
            margin: 0;
            color: #1e3a8a;
            font-size: 20px;
        }
        .header p {
            margin: 4px 0 0 0;
            color: #64748b;
            font-size: 11px;
        }
        .summary-box {
            width: 100%;
            margin-bottom: 20px;
            border-collapse: collapse;
        }
        .summary-box td {
            padding: 8px 12px;
            border: 1px solid #cbd5e1;
            width: 33.33%;
        }
        .summary-title {
            font-size: 9px;
            color: #64748b;
            text-transform: uppercase;
            font-weight: bold;
        }
        .summary-val {
            font-size: 14px;
            font-weight: bold;
            margin-top: 2px;
        }
        .text-green { color: #10b981; }
        .text-red { color: #ef4444; }
        
        table.transactions {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        table.transactions th {
            background-color: #f8fafc;
            border-bottom: 2px solid #94a3b8;
            color: #334155;
            font-weight: bold;
            text-align: left;
            padding: 6px 8px;
            font-size: 11px;
        }
        table.transactions td {
            padding: 6px 8px;
            border-bottom: 1px solid #e2e8f0;
            vertical-align: top;
        }
        .text-right { text-align: right; }
        .badge {
            display: inline-block;
            padding: 1px 4px;
            border-radius: 3px;
            font-size: 9px;
            font-weight: bold;
        }
        .badge-income { background-color: #d1fae5; color: #065f46; }
        .badge-expense { background-color: #fee2e2; color: #991b1b; }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #94a3b8;
        }
    </style>
</head>
<body>

    <div class="header">
        <h2>Laporan Transaksi Keuangan</h2>
        <p>Dicetak pada: {{ now()->format('d M Y H:i') }}</p>
    </div>

    <table class="summary-box">
        <tr>
            <td>
                <div class="summary-title">Total Pemasukan</div>
                <div class="summary-val text-green">Rp {{ number_format($totalIncome, 0, ',', '.') }}</div>
            </td>
            <td>
                <div class="summary-title">Total Pengeluaran</div>
                <div class="summary-val text-red">Rp {{ number_format($totalExpense, 0, ',', '.') }}</div>
            </td>
            <td>
                <div class="summary-title">Saldo Bersih</div>
                <div class="summary-val {{ $netBalance >= 0 ? 'text-green' : 'text-red' }}">
                    Rp {{ number_format($netBalance, 0, ',', '.') }}
                </div>
            </td>
        </tr>
    </table>

    <table class="transactions">
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Judul & Catatan</th>
                <th>Tipe</th>
                <th>Dompet</th>
                <th>Kategori</th>
                <th class="text-right">Jumlah</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($transactions as $trx)
                <tr>
                    <td style="white-space: nowrap;">{{ $trx->date->format('d M Y') }}</td>
                    <td>
                        <strong>{{ $trx->title }}</strong>
                        @if($trx->description)
                            <div style="font-size: 10px; color: #64748b; font-weight: normal; margin-top: 1px;">{{ $trx->description }}</div>
                        @endif
                    </td>
                    <td>
                        <span class="badge {{ $trx->type === 'income' ? 'badge-income' : 'badge-expense' }}">
                            {{ $trx->type === 'income' ? 'Pemasukan' : 'Pengeluaran' }}
                        </span>
                    </td>
                    <td>{{ $trx->wallet ? $trx->wallet->name : 'Tanpa Dompet' }}</td>
                    <td>{{ $trx->category ? $trx->category->name : '-' }}</td>
                    <td class="text-right {{ $trx->type === 'income' ? 'text-green' : 'text-red' }}" style="font-weight: bold; white-space: nowrap;">
                        {{ $trx->type === 'income' ? '+' : '-' }} Rp {{ number_format($trx->amount, 0, ',', '.') }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align: center; color: #64748b; padding: 15px;">Tidak ada transaksi ditemukan.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>Laporan Keuangan Personal - Dibuat secara otomatis</p>
    </div>

</body>
</html>
