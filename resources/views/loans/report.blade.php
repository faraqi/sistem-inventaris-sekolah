<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Peminjaman Inventaris Sekolah</title>
    <style>
        body { font-family: sans-serif; margin: 20px; color: #333; }
        h1 { text-align: center; margin-bottom: 5px; font-size: 20px; }
        p.subtitle { text-align: center; margin-top: 0; color: #666; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; font-size: 12px; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; font-weight: bold; }
        .text-center { text-align: center; }
        .badge { padding: 3px 6px; border-radius: 4px; font-size: 10px; font-weight: bold; }
        @media print {
            .no-print { display: none; }
        }
    </style>
</head>
<body>
    <div class="no-print" style="margin-bottom: 20px; text-align: right;">
        <button onclick="window.print()" style="padding: 8px 16px; background: #ec4899; color: white; border: none; border-radius: 8px; cursor: pointer; font-weight: bold; box-shadow: 0 4px 6px -1px rgba(236, 72, 153, 0.2);">
            Cetak / Export PDF
        </button>
    </div>

    <h1>LAPORAN PEMINJAMAN INVENTARIS SEKOLAH</h1>
    <p class="subtitle">Dicetak pada: {{ date('d F Y, H:i') }} | Total Data: {{ count($loans) }} Transaksi</p>

    <table>
        <thead>
            <tr>
                <th class="text-center">No</th>
                <th>Peminjam</th>
                <th>Kode Barang</th>
                <th>Nama Barang</th>
                <th class="text-center">Jumlah</th>
                <th>Tgl Pinjam</th>
                <th>Batas Kembali</th>
                <th class="text-center">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($loans as $index => $loan)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $loan->user->name ?? '-' }}</td>
                    <td><code>{{ $loan->item->code ?? '-' }}</code></td>
                    <td>{{ $loan->item->name ?? '-' }}</td>
                    <td class="text-center">{{ number_format($loan->quantity, 0, ',', '.') }}</td>
                    <td>{{ $loan->loan_date ? $loan->loan_date->translatedFormat('d M Y') : '-' }}</td>
                    <td>{{ $loan->due_date ? $loan->due_date->translatedFormat('d M Y') : '-' }}</td>
                    <td class="text-center uppercase font-bold">{{ $loan->status }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center">Tidak ada data peminjaman.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
