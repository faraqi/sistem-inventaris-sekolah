<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-xl text-gray-800 leading-tight">
                Detail Transaksi Peminjaman #{{ $loan->id }}
            </h2>
            <a href="{{ route('loans.index') }}" class="text-sm text-gray-600 hover:text-orange-600 font-medium transition">&larr; Kembali ke Riwayat Peminjaman</a>
        </div>
    </x-slot>

    <div class="py-6 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 space-y-6">
            <!-- Header status badge -->
            <div class="flex items-center justify-between pb-4 border-b border-gray-100">
                <div>
                    <span class="text-xs text-gray-400 font-mono">TRX-ID: #{{ $loan->id }}</span>
                    <h3 class="text-xl font-extrabold text-gray-900 mt-1">Peminjaman {{ $loan->item->name ?? '-' }}</h3>
                </div>
                <div>
                    @if($loan->status === 'dipinjam')
                        <span class="px-3 py-1.5 text-sm font-extrabold rounded-full bg-amber-100 text-amber-800">Sedang Dipinjam</span>
                    @elseif($loan->status === 'dikembalikan')
                        <span class="px-3 py-1.5 text-sm font-extrabold rounded-full bg-emerald-100 text-emerald-800">Sudah Dikembalikan</span>
                    @else
                        <span class="px-3 py-1.5 text-sm font-extrabold rounded-full bg-rose-100 text-rose-800">Terlambat Pengembalian</span>
                    @endif
                </div>
            </div>

            <!-- Detail Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-sm">
                <!-- Borrower & Item -->
                <div class="space-y-4">
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-xs font-bold uppercase text-gray-400">Peminjam</p>
                        <p class="text-base font-bold text-gray-900 mt-1">{{ $loan->user->name ?? '-' }}</p>
                        <p class="text-xs text-gray-500">{{ $loan->user->email ?? '-' }}</p>
                    </div>

                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-xs font-bold uppercase text-gray-400">Barang Inventaris</p>
                        <p class="text-base font-bold text-orange-600 mt-1">{{ $loan->item->name ?? '-' }}</p>
                        <p class="text-xs font-mono text-gray-500">SKU: {{ $loan->item->code ?? '-' }} | Kategori: {{ $loan->item->category->name ?? '-' }}</p>
                        <p class="text-sm font-bold text-gray-800 mt-2">Jumlah: {{ number_format($loan->quantity, 0, ',', '.') }} unit</p>
                    </div>
                </div>

                <!-- Timestamps & Return Log -->
                <div class="space-y-4">
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-xs font-bold uppercase text-gray-400">Jadwal Peminjaman</p>
                        <div class="mt-2 space-y-1 text-xs text-gray-700">
                            <p>Tanggal Pinjam: <strong>{{ $loan->loan_date ? $loan->loan_date->translatedFormat('d F Y') : '-' }}</strong></p>
                            <p>Batas Pengembalian: <strong class="text-rose-600">{{ $loan->due_date ? $loan->due_date->translatedFormat('d F Y') : '-' }}</strong></p>
                        </div>
                    </div>

                    @if($loan->returnLog)
                        <div class="bg-emerald-50 border border-emerald-200 p-4 rounded-lg text-emerald-900">
                            <p class="text-xs font-bold uppercase text-emerald-700">Catatan Pengembalian</p>
                            <p class="text-xs mt-1">Tanggal Dikembalikan: <strong>{{ $loan->returnLog->returned_at->translatedFormat('d F Y') }}</strong></p>
                            <p class="text-xs mt-1">Kondisi Barang: <strong class="uppercase">{{ $loan->returnLog->condition_on_return }}</strong></p>
                            @if($loan->returnLog->notes)
                                <p class="text-xs mt-2 italic bg-white p-2 rounded border border-emerald-100">"{{ $loan->returnLog->notes }}"</p>
                            @endif
                        </div>
                    @endif
                </div>
            </div>

            <!-- Admin Actions -->
            @if(Auth::user()->isAdmin() && in_array($loan->status, ['dipinjam', 'terlambat']))
                <div class="pt-4 border-t border-gray-100 flex justify-end">
                    <a href="{{ route('returns.create', ['loan_id' => $loan->id]) }}" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold px-5 py-2.5 rounded-lg shadow transition">
                        Proses Pengembalian Barang Ini
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
