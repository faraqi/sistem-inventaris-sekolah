<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-xl text-gray-800 leading-tight">
                Detail Barang: {{ $item->name }}
            </h2>
            <a href="{{ route('items.index') }}" class="text-sm text-gray-600 hover:text-gray-900 font-medium">&larr; Kembali ke Katalog</a>
        </div>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
        <!-- Main Item Detail Card -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <div class="flex flex-col md:flex-row md:items-center justify-between pb-6 border-b border-gray-100 gap-4">
                <div>
                    <span class="bg-indigo-50 text-indigo-700 px-3 py-1 rounded-full text-xs font-bold uppercase">
                        {{ $item->category->name ?? 'Umum' }}
                    </span>
                    <h1 class="text-2xl font-extrabold text-gray-900 mt-2">{{ $item->name }}</h1>
                    <p class="text-sm font-mono text-gray-500 mt-1">Kode SKU: <strong>{{ $item->code }}</strong></p>
                </div>
                <div class="flex items-center space-x-3">
                    @if($item->stock > 0)
                        <a href="{{ route('loans.create', ['item_id' => $item->id]) }}" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-sm px-4 py-2 rounded-lg shadow transition">
                            + Pinjam Barang Ini
                        </a>
                    @endif
                    @if(Auth::user()->isAdmin())
                        <a href="{{ route('items.edit', $item) }}" class="bg-amber-500 hover:bg-amber-600 text-white font-bold text-sm px-4 py-2 rounded-lg shadow transition">
                            Edit Barang
                        </a>
                    @endif
                </div>
            </div>

            <!-- Specs Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 pt-6">
                <div class="bg-gray-50 rounded-lg p-4 text-center">
                    <p class="text-xs text-gray-400 font-bold uppercase">Stok Tersedia</p>
                    <p class="text-3xl font-extrabold text-indigo-600 mt-1">{{ number_format($item->stock, 0, ',', '.') }}</p>
                </div>
                <div class="bg-gray-50 rounded-lg p-4 text-center">
                    <p class="text-xs text-gray-400 font-bold uppercase">Kondisi Barang</p>
                    <p class="text-xl font-extrabold mt-2 uppercase {{ $item->condition === 'baik' ? 'text-emerald-600' : 'text-amber-600' }}">
                        {{ $item->condition }}
                    </p>
                </div>
                <div class="bg-gray-50 rounded-lg p-4 text-center">
                    <p class="text-xs text-gray-400 font-bold uppercase">Total Transaksi Dipinjam</p>
                    <p class="text-3xl font-extrabold text-gray-800 mt-1">{{ number_format($item->loans->count(), 0, ',', '.') }}x</p>
                </div>
            </div>
        </div>

        <!-- Loan History for this Item -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
            <h3 class="font-bold text-gray-800 text-base mb-4">Riwayat Peminjaman Barang Ini</h3>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-gray-600">
                    <thead class="bg-gray-50 text-gray-700 uppercase text-xs">
                        <tr>
                            <th class="px-4 py-3">Peminjam</th>
                            <th class="px-4 py-3">Jumlah</th>
                            <th class="px-4 py-3">Tgl Pinjam</th>
                            <th class="px-4 py-3">Batas Kembali</th>
                            <th class="px-4 py-3">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($item->loans as $loan)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 font-semibold text-gray-800">
                                    {{ $loan->user->name ?? '-' }}
                                </td>
                                <td class="px-4 py-3 font-bold text-gray-800">
                                    {{ number_format($loan->quantity, 0, ',', '.') }} unit
                                </td>
                                <td class="px-4 py-3 text-xs text-gray-600">
                                    {{ $loan->loan_date ? $loan->loan_date->translatedFormat('d M Y') : '-' }}
                                </td>
                                <td class="px-4 py-3 text-xs text-gray-600">
                                    {{ $loan->due_date ? $loan->due_date->translatedFormat('d M Y') : '-' }}
                                </td>
                                <td class="px-4 py-3">
                                    @if($loan->status === 'dipinjam')
                                        <span class="px-2.5 py-1 text-xs font-bold rounded-full bg-amber-100 text-amber-800">Dipinjam</span>
                                    @elseif($loan->status === 'dikembalikan')
                                        <span class="px-2.5 py-1 text-xs font-bold rounded-full bg-emerald-100 text-emerald-800">Dikembalikan</span>
                                    @else
                                        <span class="px-2.5 py-1 text-xs font-bold rounded-full bg-rose-100 text-rose-800">Terlambat</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-4 text-center text-gray-500">Belum ada riwayat peminjaman untuk barang ini.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
