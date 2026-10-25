<x-app-layout>
    <div class="space-y-6">
        <!-- Page Header & Action Buttons -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white p-5 rounded-2xl shadow-sm border border-slate-100">
            <div>
                <h1 class="text-xl font-bold text-slate-800 tracking-tight">
                    {{ Auth::user()->isAdmin() ? 'Daftar Seluruh Peminjaman Barang' : 'Riwayat Peminjaman Barang Saya' }}
                </h1>
                <p class="text-xs text-slate-500 mt-0.5">Pantau status persetujuan, barang dipinjam, dan tanggal pengembalian.</p>
            </div>
            <div class="flex items-center gap-2">
                @if(Auth::user()->isAdmin())
                    <a href="{{ route('loans.report') }}" target="_blank" class="inline-flex items-center justify-center gap-2 bg-slate-800 hover:bg-slate-900 text-white text-xs font-bold px-4 py-2.5 rounded-xl shadow-md transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                        </svg>
                        <span>Cetak Laporan</span>
                    </a>
                @endif
                <a href="{{ route('loans.create') }}" class="inline-flex items-center justify-center gap-2 bg-orange-500 hover:bg-orange-600 text-white text-xs font-bold px-4 py-2.5 rounded-xl shadow-md shadow-orange-200 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    <span>Ajukan Peminjaman</span>
                </a>
            </div>
        </div>

        <!-- Filter Bar -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
            <form method="GET" action="{{ route('loans.index') }}" class="grid grid-cols-1 md:grid-cols-3 gap-3">
                <div>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama peminjam / barang..." class="w-full rounded-lg border-gray-300 text-sm focus:border-orange-400 focus:ring-orange-300">
                </div>
                <div>
                    <select name="status" class="w-full rounded-lg border-gray-300 text-sm focus:border-orange-400 focus:ring-orange-300">
                        <option value="">-- Semua Status --</option>
                        <option value="dipinjam" {{ request('status') == 'dipinjam' ? 'selected' : '' }}>Dipinjam (Aktif)</option>
                        <option value="dikembalikan" {{ request('status') == 'dikembalikan' ? 'selected' : '' }}>Dikembalikan</option>
                        <option value="terlambat" {{ request('status') == 'terlambat' ? 'selected' : '' }}>Terlambat</option>
                    </select>
                </div>
                <div class="flex items-center space-x-2">
                    <button type="submit" class="w-full bg-orange-500 hover:bg-orange-600 text-white font-bold text-sm py-2 rounded-lg shadow-sm shadow-orange-200 transition">Filter</button>
                    @if(request('search') || request('status'))
                        <a href="{{ route('loans.index') }}" class="px-3 py-2 border border-gray-300 rounded-lg text-xs font-semibold text-gray-600 hover:bg-gray-50">Reset</a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Table -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
            <table class="w-full min-w-[900px] text-left text-sm text-gray-600">
                <thead class="bg-gray-50 text-gray-700 uppercase text-xs border-b border-gray-100">
                    <tr>
                        <th class="px-6 py-4">No</th>
                        <th class="px-6 py-4">Peminjam</th>
                        <th class="px-6 py-4">Barang</th>
                        <th class="px-6 py-4">Jumlah</th>
                        <th class="px-6 py-4">Tgl Pinjam</th>
                        <th class="px-6 py-4">Batas Kembali</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($loans as $index => $loan)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 font-mono text-xs text-gray-400">
                                {{ $loans->firstItem() + $index }}
                            </td>
                            <td class="px-6 py-4 font-bold text-gray-900">
                                {{ $loan->user->name ?? '-' }}
                                <span class="block text-xs font-normal text-gray-400">{{ $loan->user->email ?? '' }}</span>
                            </td>
                            <td class="px-6 py-4 font-semibold text-orange-600">
                                {{ $loan->item->name ?? '-' }}
                                <span class="block text-xs font-mono font-normal text-gray-400">{{ $loan->item->code ?? '' }}</span>
                            </td>
                            <td class="px-6 py-4 font-extrabold text-gray-800">
                                {{ number_format($loan->quantity, 0, ',', '.') }} unit
                            </td>
                            <td class="px-6 py-4 text-xs text-gray-600 whitespace-nowrap">
                                {{ $loan->loan_date ? $loan->loan_date->translatedFormat('d M Y') : '-' }}
                            </td>
                            <td class="px-6 py-4 text-xs font-semibold text-gray-700 whitespace-nowrap">
                                {{ $loan->due_date ? $loan->due_date->translatedFormat('d M Y') : '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($loan->status === 'dipinjam')
                                    <span class="px-2.5 py-1 text-xs font-bold rounded-full bg-amber-100 text-amber-800">Dipinjam</span>
                                @elseif($loan->status === 'dikembalikan')
                                    <span class="px-2.5 py-1 text-xs font-bold rounded-full bg-emerald-100 text-emerald-800">Dikembalikan</span>
                                @else
                                    <span class="px-2.5 py-1 text-xs font-bold rounded-full bg-rose-100 text-rose-800">Terlambat</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center space-x-1 whitespace-nowrap">
                                <a href="{{ route('loans.show', $loan) }}" class="inline-block bg-gray-100 text-gray-700 hover:bg-gray-200 font-semibold px-2.5 py-1 rounded text-xs">Detail</a>

                                @if(Auth::user()->isAdmin())
                                    @if(in_array($loan->status, ['dipinjam', 'terlambat']))
                                        <a href="{{ route('returns.create', ['loan_id' => $loan->id]) }}" class="inline-block bg-emerald-600 hover:bg-emerald-700 text-white font-bold px-2.5 py-1 rounded text-xs shadow-sm">
                                            Kembalikan
                                        </a>
                                    @endif
                                    <form method="POST" action="{{ route('loans.destroy', $loan) }}" class="inline-block" onsubmit="return confirm('Hapus transaksi peminjaman ini (Soft Delete)?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-rose-50 text-rose-700 hover:bg-rose-100 font-semibold px-2.5 py-1 rounded text-xs">Hapus</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-8 text-center text-gray-500">
                                Belum ada data transaksi peminjaman barang.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            </div>
            <div class="p-4 border-t border-gray-100">
                {{ $loans->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
