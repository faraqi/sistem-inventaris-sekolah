<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-xl text-gray-800 leading-tight flex items-center gap-2">
                <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                </svg>
                Dashboard Admin - Overview Inventaris
            </h2>
            <span class="text-sm bg-orange-100 text-orange-700 px-3 py-1 rounded-full font-medium border border-orange-200/80">Administrator (admin)</span>
        </div>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
        <!-- 4 Metric Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-5">
            <!-- Total Barang -->
            <div class="bg-white rounded-xl p-5 shadow-sm border border-orange-100 border-l-4 border-l-orange-500 flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold uppercase tracking-wider text-gray-400">TOTAL BARANG</p>
                    <h3 class="text-3xl font-extrabold text-gray-900 mt-1">{{ number_format($totalItems, 0, ',', '.') }}</h3>
                    <p class="text-xs text-gray-400 mt-0.5">Jenis Barang Registered</p>
                </div>
                <div class="p-3 bg-orange-50 rounded-lg text-orange-600">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                </div>
            </div>

            <!-- Total Stok -->
            <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100 border-l-4 border-l-emerald-500 flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold uppercase tracking-wider text-gray-400">TOTAL STOK</p>
                    <h3 class="text-3xl font-extrabold text-gray-900 mt-1">{{ number_format($totalStock, 0, ',', '.') }}</h3>
                    <p class="text-xs text-gray-400 mt-0.5">Unit Tersedia di Gudang</p>
                </div>
                <div class="p-3 bg-emerald-50 rounded-lg text-emerald-600">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 01-2-2V5a2 2 0 012-2h14a2 2 0 012 2v1a2 2 0 01-2 2M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                    </svg>
                </div>
            </div>

            <!-- Sedang Dipinjam -->
            <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100 border-l-4 border-l-amber-500 flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold uppercase tracking-wider text-gray-400">SEDANG DIPINJAM</p>
                    <h3 class="text-3xl font-extrabold text-gray-900 mt-1">{{ number_format($activeLoansCount, 0, ',', '.') }}</h3>
                    <p class="text-xs text-amber-600 font-medium mt-0.5">{{ $activeLoansTxCount }} Transaksi Aktif</p>
                </div>
                <div class="p-3 bg-amber-50 rounded-lg text-amber-600">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                    </svg>
                </div>
            </div>

            <!-- Terlambat -->
            <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100 border-l-4 border-l-rose-500 flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold uppercase tracking-wider text-gray-400">TERLAMBAT</p>
                    <h3 class="text-3xl font-extrabold text-gray-900 mt-1">{{ number_format($overdueLoansCount, 0, ',', '.') }}</h3>
                    <p class="text-xs text-rose-600 font-medium mt-0.5">{{ $overdueLoansTxCount }} Transaksi Overdue</p>
                </div>
                <div class="p-3 bg-rose-50 rounded-lg text-rose-600">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- 2 Column Widgets: Popular Items & Active Users -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Barang Paling Sering Dipinjam -->
            <div class="bg-white rounded-xl shadow-sm border border-orange-100 p-5">
                <div class="flex items-center justify-between pb-3 border-b border-orange-100/60 mb-4">
                    <h3 class="font-bold text-gray-800 text-base flex items-center gap-2">
                        <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                        </svg>
                        Barang Paling Sering Dipinjam
                    </h3>
                    <a href="{{ route('items.index') }}" class="text-xs text-orange-600 hover:underline">Lihat Semua</a>
                </div>
                <div class="space-y-3">
                    @forelse($popularItems as $item)
                        <div class="flex items-center justify-between p-3 bg-orange-50/30 rounded-lg hover:bg-orange-50/70 transition">
                            <div class="flex items-center space-x-3">
                                <span class="w-8 h-8 rounded-full bg-orange-100 text-orange-700 font-bold text-xs flex items-center justify-center">
                                    {{ $loop->iteration }}
                                </span>
                                <div>
                                    <p class="font-semibold text-gray-800 text-sm">{{ $item->name }}</p>
                                    <p class="text-xs text-gray-500">{{ $item->code }} &bull; Stok: {{ number_format($item->stock, 0, ',', '.') }}</p>
                                </div>
                            </div>
                            <span class="px-2.5 py-1 bg-orange-500 text-white rounded-full text-xs font-bold shadow-sm">
                                {{ $item->loans_count }}x dipinjam
                            </span>
                        </div>
                    @empty
                        <p class="text-sm text-gray-500 text-center py-4">Belum ada data peminjaman barang.</p>
                    @endforelse
                </div>
            </div>

            <!-- User Paling Aktif -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
                <div class="flex items-center justify-between pb-3 border-b border-gray-100 mb-4">
                    <h3 class="font-bold text-gray-800 text-base flex items-center gap-2">
                        <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        User Paling Aktif
                    </h3>
                    <a href="{{ route('users.index') }}" class="text-xs text-emerald-600 hover:underline">Lihat Semua</a>
                </div>
                <div class="space-y-3">
                    @forelse($activeUsers as $u)
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-emerald-50/50 transition">
                            <div class="flex items-center space-x-3">
                                <div class="w-8 h-8 rounded-full bg-emerald-100 text-emerald-800 font-bold text-xs flex items-center justify-center">
                                    {{ strtoupper(substr($u->name, 0, 2)) }}
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-800 text-sm">{{ $u->name }}</p>
                                    <p class="text-xs text-gray-500">{{ $u->email }}</p>
                                </div>
                            </div>
                            <span class="px-2.5 py-1 bg-emerald-600 text-white rounded-full text-xs font-bold shadow-sm">
                                {{ $u->loans_count }}x transaksi
                            </span>
                        </div>
                    @empty
                        <p class="text-sm text-gray-500 text-center py-4">Belum ada data user aktif.</p>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Recent Activity Logs Table -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
            <div class="flex items-center justify-between pb-3 border-b border-gray-100 mb-4">
                <h3 class="font-bold text-gray-800 text-base flex items-center gap-2">
                    <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Aktivitas Terbaru (Audit Trail)
                </h3>
                <a href="{{ route('activity_logs.index') }}" class="text-xs text-amber-600 hover:underline">Selengkapnya</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-gray-600">
                    <thead class="bg-gray-50 text-gray-700 uppercase text-xs">
                        <tr>
                            <th class="px-4 py-3">Waktu</th>
                            <th class="px-4 py-3">Pengguna</th>
                            <th class="px-4 py-3">Aksi</th>
                            <th class="px-4 py-3">Deskripsi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($recentActivities as $activity)
                            <tr class="hover:bg-gray-50/80">
                                <td class="px-4 py-3 whitespace-nowrap text-xs text-gray-500">
                                    {{ $activity->created_at->translatedFormat('d M Y, H:i') }}
                                </td>
                                <td class="px-4 py-3 font-medium text-gray-800">
                                    {{ $activity->user->name ?? 'System' }}
                                </td>
                                <td class="px-4 py-3">
                                    <span class="px-2 py-0.5 text-xs font-mono rounded bg-gray-100 text-gray-800">
                                        {{ $activity->action }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-gray-600">
                                    {{ $activity->description }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-4 py-4 text-center text-gray-500">Belum ada catatan aktivitas.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
