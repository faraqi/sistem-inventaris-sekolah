<x-app-layout>
    <div class="space-y-6">
        <!-- Page Header & Action Button -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white p-5 rounded-2xl shadow-sm border border-slate-100">
            <div>
                <h1 class="text-xl font-bold text-slate-800 tracking-tight">
                    {{ Auth::user()->isAdmin() ? 'Kelola Data Barang Inventaris' : 'Katalog Barang Inventaris Sekolah' }}
                </h1>
                <p class="text-xs text-slate-500 mt-0.5">Kelola seluruh daftar aset dan barang inventaris sekolah.</p>
            </div>
            @if(Auth::user()->isAdmin())
                <a href="{{ route('items.create') }}" class="inline-flex items-center justify-center gap-2 bg-orange-500 hover:bg-orange-600 text-white text-xs font-bold px-4 py-2.5 rounded-xl shadow-md shadow-orange-200 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    <span>Tambah Barang Baru</span>
                </a>
            @else
                <a href="{{ route('loans.create') }}" class="inline-flex items-center justify-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold px-4 py-2.5 rounded-xl shadow-md shadow-emerald-200 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    <span>Ajukan Peminjaman</span>
                </a>
            @endif
        </div>

        <!-- Search & Filter Bar -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
            <form method="GET" action="{{ route('items.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-3">
                <!-- Search Input -->
                <div class="md:col-span-1">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama / kode barang..." class="w-full rounded-lg border-gray-300 text-sm focus:border-orange-400 focus:ring-orange-300">
                </div>

                <!-- Category Filter -->
                <div>
                    <select name="category_id" class="w-full rounded-lg border-gray-300 text-sm focus:border-orange-400 focus:ring-orange-300">
                        <option value="">-- Semua Kategori --</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Condition Filter -->
                <div>
                    <select name="condition" class="w-full rounded-lg border-gray-300 text-sm focus:border-orange-400 focus:ring-orange-300">
                        <option value="">-- Semua Kondisi --</option>
                        <option value="baik" {{ request('condition') == 'baik' ? 'selected' : '' }}>Baik</option>
                        <option value="rusak ringan" {{ request('condition') == 'rusak ringan' ? 'selected' : '' }}>Rusak Ringan</option>
                        <option value="rusak berat" {{ request('condition') == 'rusak berat' ? 'selected' : '' }}>Rusak Berat</option>
                    </select>
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center space-x-2">
                    <button type="submit" class="w-full bg-orange-500 hover:bg-orange-600 text-white font-bold text-sm py-2 rounded-lg shadow-sm shadow-orange-200 transition">
                        Filter Data
                    </button>
                    @if(request('search') || request('category_id') || request('condition') || request('trashed'))
                        <a href="{{ route('items.index') }}" class="px-3 py-2 border border-gray-300 rounded-lg text-xs font-semibold text-gray-600 hover:bg-gray-50">Reset</a>
                    @endif
                </div>
            </form>

            @if(Auth::user()->isAdmin())
                <div class="mt-3 pt-3 border-t border-gray-100 flex items-center justify-between text-xs">
                    <a href="{{ route('items.index', array_merge(request()->all(), ['trashed' => request('trashed') ? 0 : 1])) }}" class="text-orange-600 hover:underline font-semibold flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        {{ request('trashed') ? 'Tampilkan Barang Aktif' : 'Tampilkan Barang Dihapus (Soft Delete)' }}
                    </a>
                    <span class="text-gray-500">Total Barang: <strong>{{ number_format($items->total(), 0, ',', '.') }}</strong></span>
                </div>
            @endif
        </div>

        <!-- Table -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
            <table class="w-full min-w-[720px] text-left text-sm text-gray-600">
                <thead class="bg-gray-50 text-gray-700 uppercase text-xs border-b border-gray-100">
                    <tr>
                        <th class="px-6 py-4">Kode SKU</th>
                        <th class="px-6 py-4">Nama Barang</th>
                        <th class="px-6 py-4">Kategori</th>
                        <th class="px-6 py-4">Stok Tersedia</th>
                        <th class="px-6 py-4">Kondisi</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($items as $item)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 font-mono font-bold text-xs text-orange-600">
                                {{ $item->code }}
                            </td>
                            <td class="px-6 py-4 font-bold text-gray-900">
                                <a href="{{ route('items.show', $item) }}" class="hover:text-orange-600">
                                    {{ $item->name }}
                                </a>
                            </td>
                            <td class="px-6 py-4 text-gray-700">
                                <span class="bg-orange-50 text-orange-700 border border-orange-100 text-xs px-2.5 py-1 rounded-full font-medium">
                                    {{ $item->category->name ?? '-' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 font-bold text-gray-900">
                                {{ number_format($item->stock, 0, ',', '.') }} unit
                            </td>
                            <td class="px-6 py-4">
                                @if($item->condition === 'baik')
                                    <span class="px-2.5 py-1 text-xs font-bold rounded-full bg-emerald-100 text-emerald-800 uppercase">Baik</span>
                                @elseif($item->condition === 'rusak ringan')
                                    <span class="px-2.5 py-1 text-xs font-bold rounded-full bg-amber-100 text-amber-800 uppercase">Rusak Ringan</span>
                                @else
                                    <span class="px-2.5 py-1 text-xs font-bold rounded-full bg-rose-100 text-rose-800 uppercase">Rusak Berat</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center space-x-2">
                                <a href="{{ route('items.show', $item) }}" class="inline-block bg-gray-100 text-gray-700 hover:bg-gray-200 font-semibold px-3 py-1 rounded text-xs">Detail</a>

                                @if(Auth::user()->isAdmin())
                                    @if($item->trashed())
                                        <form method="POST" action="{{ route('items.restore', $item->id) }}" class="inline-block">
                                            @csrf
                                            <button type="submit" class="bg-emerald-50 text-emerald-700 hover:bg-emerald-100 font-semibold px-3 py-1 rounded text-xs">Restore</button>
                                        </form>
                                    @else
                                        <a href="{{ route('items.edit', $item) }}" class="inline-block bg-amber-50 text-amber-700 hover:bg-amber-100 font-semibold px-3 py-1 rounded text-xs">Edit</a>
                                        <form method="POST" action="{{ route('items.destroy', $item) }}" class="inline-block" onsubmit="return confirm('Hapus barang {{ $item->name }} (Soft Delete)?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-rose-50 text-rose-700 hover:bg-rose-100 font-semibold px-3 py-1 rounded text-xs">Hapus</button>
                                        </form>
                                    @endif
                                @else
                                    @if($item->stock > 0)
                                        <a href="{{ route('loans.create', ['item_id' => $item->id]) }}" class="inline-block bg-orange-500 hover:bg-orange-600 text-white font-bold px-3 py-1 rounded text-xs shadow-sm shadow-orange-200">Pinjam</a>
                                    @else
                                        <span class="text-xs text-gray-400 font-medium italic">Stok Habis</span>
                                    @endif
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                                Tidak ada data barang inventaris yang ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            </div>
            <div class="p-4 border-t border-gray-100">
                {{ $items->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
