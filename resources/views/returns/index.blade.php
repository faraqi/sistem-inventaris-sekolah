<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-xl text-gray-800 leading-tight">
                Riwayat Pengembalian Barang Inventaris
            </h2>
            <a href="{{ route('returns.create') }}" class="bg-pink-500 hover:bg-pink-600 text-white text-sm font-bold px-4 py-2 rounded-lg shadow-md shadow-pink-200 transition">
                + Catat Pengembalian Baru
            </a>
        </div>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-4">
        <!-- Search & Filter Bar -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
            <form method="GET" action="{{ route('returns.index') }}" class="grid grid-cols-1 md:grid-cols-3 gap-3">
                <div>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama peminjam / barang..." class="w-full rounded-lg border-gray-300 text-sm focus:border-pink-400 focus:ring-pink-300">
                </div>
                <div>
                    <select name="condition" class="w-full rounded-lg border-gray-300 text-sm focus:border-pink-400 focus:ring-pink-300">
                        <option value="">-- Semua Kondisi --</option>
                        <option value="baik" {{ request('condition') == 'baik' ? 'selected' : '' }}>Baik</option>
                        <option value="rusak ringan" {{ request('condition') == 'rusak ringan' ? 'selected' : '' }}>Rusak Ringan</option>
                        <option value="rusak berat" {{ request('condition') == 'rusak berat' ? 'selected' : '' }}>Rusak Berat</option>
                    </select>
                </div>
                <div class="flex items-center space-x-2">
                    <button type="submit" class="w-full bg-pink-500 hover:bg-pink-600 text-white font-bold text-sm py-2 rounded-lg shadow-sm shadow-pink-200 transition">Filter</button>
                    @if(request('search') || request('condition'))
                        <a href="{{ route('returns.index') }}" class="px-3 py-2 border border-gray-300 rounded-lg text-xs font-semibold text-gray-600 hover:bg-gray-50">Reset</a>
                    @endif
                </div>
            </form>
            <p class="mt-3 pt-3 border-t border-gray-100 text-xs text-gray-500">Total Log Pengembalian: <strong>{{ number_format($returnLogs->total(), 0, ',', '.') }}</strong></p>
        </div>

        <!-- Table -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
            <table class="w-full min-w-[760px] text-left text-sm text-gray-600">
                <thead class="bg-gray-50 text-gray-700 uppercase text-xs border-b border-gray-100">
                    <tr>
                        <th class="px-6 py-4">No</th>
                        <th class="px-6 py-4">Peminjam</th>
                        <th class="px-6 py-4">Barang</th>
                        <th class="px-6 py-4">Tgl Pengembalian</th>
                        <th class="px-6 py-4">Kondisi Pengembalian</th>
                        <th class="px-6 py-4">Catatan</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($returnLogs as $index => $log)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 font-mono text-xs text-gray-400">
                                {{ $returnLogs->firstItem() + $index }}
                            </td>
                            <td class="px-6 py-4 font-bold text-gray-900">
                                {{ $log->loan->user->name ?? '-' }}
                            </td>
                            <td class="px-6 py-4 font-semibold text-pink-600">
                                {{ $log->loan->item->name ?? '-' }}
                                <span class="block text-xs font-mono text-gray-400">({{ $log->loan->quantity ?? 1 }} unit)</span>
                            </td>
                            <td class="px-6 py-4 text-xs text-gray-700 whitespace-nowrap font-medium">
                                {{ $log->returned_at ? $log->returned_at->translatedFormat('d M Y') : '-' }}
                            </td>
                            <td class="px-6 py-4">
                                @if($log->condition_on_return === 'baik')
                                    <span class="px-2.5 py-1 text-xs font-bold rounded-full bg-emerald-100 text-emerald-800 uppercase">Baik</span>
                                @elseif($log->condition_on_return === 'rusak ringan')
                                    <span class="px-2.5 py-1 text-xs font-bold rounded-full bg-amber-100 text-amber-800 uppercase">Rusak Ringan</span>
                                @else
                                    <span class="px-2.5 py-1 text-xs font-bold rounded-full bg-rose-100 text-rose-800 uppercase">Rusak Berat</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-xs text-gray-500 max-w-xs truncate">
                                {{ $log->notes ?? '-' }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                <a href="{{ route('returns.show', $log) }}" class="bg-gray-100 text-gray-700 hover:bg-gray-200 font-semibold px-3 py-1 rounded text-xs">Detail</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-8 text-center text-gray-500">
                                Belum ada data pengembalian barang.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            </div>
            <div class="p-4 border-t border-gray-100">
                {{ $returnLogs->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
