<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-xl text-gray-800 leading-tight">
                Detail Catatan Pengembalian #{{ $returnLog->id }}
            </h2>
            <a href="{{ route('returns.index') }}" class="text-sm text-gray-600 hover:text-gray-900 font-medium">&larr; Kembali ke Riwayat Pengembalian</a>
        </div>
    </x-slot>

    <div class="py-6 max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 space-y-5 text-sm">
            <div class="flex items-center justify-between pb-4 border-b border-gray-100">
                <div>
                    <span class="text-xs text-gray-400 font-mono">LOG-ID: #{{ $returnLog->id }}</span>
                    <h3 class="text-lg font-bold text-gray-900 mt-1">
                        Pengembalian {{ $returnLog->loan->item->name ?? '-' }}
                    </h3>
                </div>
                <span class="px-3 py-1 text-xs font-bold rounded-full uppercase bg-emerald-100 text-emerald-800">
                    Dikembalikan
                </span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="bg-gray-50 p-4 rounded-lg">
                    <p class="text-xs text-gray-400 font-bold uppercase">Peminjam</p>
                    <p class="font-bold text-gray-900 mt-1">{{ $returnLog->loan->user->name ?? '-' }}</p>
                    <p class="text-xs text-gray-500">{{ $returnLog->loan->user->email ?? '-' }}</p>
                </div>
                <div class="bg-gray-50 p-4 rounded-lg">
                    <p class="text-xs text-gray-400 font-bold uppercase">Barang Inventaris</p>
                    <p class="font-bold text-indigo-700 mt-1">{{ $returnLog->loan->item->name ?? '-' }}</p>
                    <p class="text-xs text-gray-500 font-mono">Jumlah: {{ number_format($returnLog->loan->quantity ?? 1, 0, ',', '.') }} unit</p>
                </div>
            </div>

            <div class="bg-gray-50 p-4 rounded-lg space-y-2">
                <p class="text-xs text-gray-400 font-bold uppercase">Detail Verifikasi Pengembalian</p>
                <div class="text-xs space-y-1">
                    <p>Tanggal Dikembalikan: <strong>{{ $returnLog->returned_at ? $returnLog->returned_at->translatedFormat('d F Y') : '-' }}</strong></p>
                    <p>Kondisi Saat Dikembalikan: <strong class="uppercase font-bold text-emerald-700">{{ $returnLog->condition_on_return }}</strong></p>
                    <p>Catatan Admin: <span>{{ $returnLog->notes ?: 'Tidak ada catatan tambahan.' }}</span></p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
