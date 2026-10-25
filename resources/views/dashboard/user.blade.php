<x-app-layout>
    <!-- BEGIN: Refined Greeting Banner -->
    <section class="relative overflow-hidden rounded-2xl bg-white border border-slate-200/80 p-6 shadow-card" data-purpose="greeting-banner">
        <!-- Clean background accents -->
        <div class="absolute top-0 right-0 -mt-6 -mr-6 w-80 h-80 bg-gradient-to-br from-pink-100/70 via-slate-50/50 to-transparent rounded-full blur-2xl pointer-events-none"></div>
        <div class="relative z-10 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-5">
            <div>
                <div class="flex flex-wrap items-center gap-2 mb-1.5">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-[11px] font-semibold bg-slate-100 text-slate-700 border border-slate-200/80">
                        T.A. {{ date('Y') }}/{{ date('Y')+1 }} • Semester {{ date('n') > 6 ? 'Ganjil' : 'Genap' }}
                    </span>
                    <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[11px] font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200/60">
                        Akun Terverifikasi
                    </span>
                </div>
                <h1 class="text-xl sm:text-2xl font-bold tracking-tight text-slate-900">
                    Selamat Datang Kembali, {{ Auth::user()->name }}
                </h1>
                <p class="text-xs sm:text-sm text-slate-500 mt-1 max-w-2xl">
                    Akses inventaris sarana dan prasarana praktik kejuruan secara real-time. Pastikan pengembalian tepat waktu untuk menjaga skor kepatuhan peminjaman.
                </p>
            </div>
            <div class="flex items-center gap-3 shrink-0">
                <a class="inline-flex items-center gap-2 px-3.5 py-2.5 rounded-xl bg-slate-50 hover:bg-slate-100 border border-slate-200 text-slate-700 text-xs font-semibold transition-all" href="#peminjaman">
                    <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="10"></circle>
                        <polyline points="12 6 12 12 16 14"></polyline>
                    </svg>
                    <span>Cek Tenggat Pinjaman</span>
                </a>
                <a href="{{ route('loans.create') }}" class="btn-shine inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-gradient-to-r from-pink-500 to-rose-500 hover:from-pink-600 hover:to-rose-600 text-white text-xs font-semibold shadow-sm shadow-pink-500/20 hover:shadow transition-all active:scale-[0.98]">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <line x1="12" x2="12" y1="5" y2="19"></line>
                        <line x1="5" x2="19" y1="12" y2="12"></line>
                    </svg>
                    <span>Pinjam Barang Baru</span>
                </a>
            </div>
        </div>
    </section>
    <!-- END: Greeting Banner -->

    <!-- BEGIN: 4 Modern Minimalist Metric Cards -->
    <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4" data-purpose="metrics-overview">
        <!-- Metric 1: Total Transaksi -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-card hover:shadow-card-hover transition-all duration-200 flex flex-col justify-between">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-slate-500 tracking-wide uppercase">Total Transaksi</span>
                <div class="w-8 h-8 rounded-lg bg-slate-100 text-slate-700 flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"></path>
                        <rect height="4" rx="1" ry="1" width="8" x="8" y="2"></rect>
                        <path d="M9 12h6"></path>
                        <path d="M9 16h6"></path>
                    </svg>
                </div>
            </div>
            <div class="mt-4">
                <div class="flex items-baseline gap-2">
                    <span class="text-2xl sm:text-3xl font-extrabold tracking-tight text-slate-900">{{ number_format($myTotalLoans, 0, ',', '.') }}</span>
                    <span class="text-xs text-slate-400 font-medium">peminjaman</span>
                </div>
                <div class="mt-1 flex items-center gap-1.5 text-xs text-slate-500">
                    <span class="w-1.5 h-1.5 rounded-full bg-pink-500"></span>
                    <span>Aktivitas semester ini</span>
                </div>
            </div>
        </div>

        <!-- Metric 2: Pinjaman Aktif -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-card hover:shadow-card-hover transition-all duration-200 flex flex-col justify-between relative overflow-hidden">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-slate-500 tracking-wide uppercase">Pinjaman Aktif</span>
                <div class="w-8 h-8 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center border border-amber-100">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="10"></circle>
                        <polyline points="12 6 12 12 16 14"></polyline>
                    </svg>
                </div>
            </div>
            <div class="mt-4">
                <div class="flex items-baseline gap-2">
                    <span class="text-2xl sm:text-3xl font-extrabold tracking-tight text-slate-900">{{ number_format($myActiveLoans->count(), 0, ',', '.') }}</span>
                    @if($myOverdueCount > 0)
                        <span class="text-xs font-bold text-rose-600 bg-rose-50 px-2 py-0.5 rounded-md border border-rose-200/70">{{ $myOverdueCount }} Jatuh Tempo</span>
                    @endif
                </div>
                <div class="mt-1 flex items-center gap-1.5 text-xs {{ $myOverdueCount > 0 ? 'text-rose-600' : 'text-amber-600' }} font-medium">
                    <svg class="w-3.5 h-3.5 text-amber-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                    <span>{{ $myOverdueCount > 0 ? 'Segera kembalikan barang' : 'Kembalikan tepat waktu' }}</span>
                </div>
            </div>
        </div>

        <!-- Metric 3: Sudah Dikembalikan -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-card hover:shadow-card-hover transition-all duration-200 flex flex-col justify-between">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-slate-500 tracking-wide uppercase">Sudah Dikembalikan</span>
                <div class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center border border-emerald-100">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                        <polyline points="22 4 12 14.01 9 11.01"></polyline>
                    </svg>
                </div>
            </div>
            <div class="mt-4">
                <div class="flex items-baseline gap-2">
                    <span class="text-2xl sm:text-3xl font-extrabold tracking-tight text-slate-900">{{ number_format($myReturnedLoans, 0, ',', '.') }}</span>
                    <span class="text-xs text-slate-400 font-medium">unit barang</span>
                </div>
                <div class="mt-1 flex items-center gap-1.5 text-xs text-emerald-700 font-medium">
                    <svg class="w-3.5 h-3.5 text-emerald-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <polyline points="20 6 9 17 4 12"></polyline>
                    </svg>
                    <span>Verifikasi barang sesuai</span>
                </div>
            </div>
        </div>

        <!-- Metric 4: Skor Kepatuhan -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-card hover:shadow-card-hover transition-all duration-200 flex flex-col justify-between">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-slate-500 tracking-wide uppercase">Skor Kepatuhan</span>
                <div class="w-8 h-8 rounded-lg bg-pink-50 text-pink-600 flex items-center justify-center border border-pink-100">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                    </svg>
                </div>
            </div>
            <div class="mt-4">
                <div class="flex items-baseline gap-2">
                    <span class="text-2xl sm:text-3xl font-extrabold tracking-tight text-slate-900">{{ $complianceScore }}<span class="text-lg text-slate-500 font-bold">%</span></span>
                    @if($myTotalLoans == 0)
                        <span class="text-[11px] font-semibold px-2 py-0.5 rounded bg-emerald-50 text-emerald-700 border border-emerald-200/60">Akun Bersih</span>
                    @elseif($complianceScore >= 85)
                        <span class="text-[11px] font-semibold px-2 py-0.5 rounded bg-emerald-50 text-emerald-700 border border-emerald-200/60">Sangat Baik</span>
                    @elseif($complianceScore >= 70)
                        <span class="text-[11px] font-semibold px-2 py-0.5 rounded bg-amber-50 text-amber-700 border border-amber-200/60">Cukup Baik</span>
                    @else
                        <span class="text-[11px] font-semibold px-2 py-0.5 rounded bg-rose-50 text-rose-700 border border-rose-200/60">Perlu Perhatian</span>
                    @endif
                </div>
                <div class="mt-2 w-full bg-slate-100 rounded-full h-1.5 overflow-hidden">
                    <div class="bg-gradient-to-r from-pink-500 to-rose-400 h-1.5 rounded-full" style="width: {{ $complianceScore }}%"></div>
                </div>
            </div>
        </div>
    </section>
    <!-- END: 4 Modern Minimalist Metric Cards -->

    <!-- BEGIN: Active Borrowings Table Section -->
    <section class="bg-white rounded-2xl border border-slate-200/80 shadow-card overflow-hidden" data-purpose="active-loans-table" id="peminjaman">
        <!-- Section Header -->
        <div class="px-6 py-4.5 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 bg-slate-50/50">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-amber-500/10 text-amber-600 flex items-center justify-center border border-amber-500/20">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="10"></circle>
                        <polyline points="12 6 12 12 16 14"></polyline>
                    </svg>
                </div>
                <div>
                    <h2 class="text-sm sm:text-base font-bold text-slate-900">Peminjaman Aktif dalam Tanggungan</h2>
                    <p class="text-xs text-slate-500">Daftar barang yang wajib dikembalikan ke ruang inventaris sekolah sesuai tenggat</p>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <a class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-600 hover:text-pink-600 px-3 py-1.5 rounded-lg hover:bg-slate-100/80 transition-colors" href="{{ route('loans.index') }}">
                    <span>Lihat Semua Riwayat ({{ $myTotalLoans }})</span>
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M5 12h14"></path>
                        <path d="m12 5 7 7-7 7"></path>
                    </svg>
                </a>
            </div>
        </div>
        <!-- Modern Crisp Table -->
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/80 text-[11px] font-bold text-slate-500 uppercase tracking-wider border-b border-slate-200/60">
                        <th class="py-3 px-6" scope="col">Aset & Barang</th>
                        <th class="py-3 px-6" scope="col">Jumlah</th>
                        <th class="py-3 px-6" scope="col">Tgl Peminjaman</th>
                        <th class="py-3 px-6" scope="col">Tenggat Waktu</th>
                        <th class="py-3 px-6" scope="col">Status Pengembalian</th>
                        <th class="py-3 px-6 text-right" scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-xs">
                    @forelse($myActiveLoans as $loan)
                        @php
                            $isOverdue = $loan->status === 'terlambat' || ($loan->due_date && $loan->due_date->isPast() && !$loan->due_date->isToday());
                            $daysDiff = $loan->due_date ? abs(now()->startOfDay()->diffInDays($loan->due_date->startOfDay(), false)) : 0;
                            $catName = strtolower($loan->item->category->name ?? '');
                        @endphp
                        <tr class="{{ $isOverdue ? 'hover:bg-rose-50/20' : 'hover:bg-slate-50/60' }} transition-colors group">
                            <td class="py-4 px-6">
                                <div class="flex items-center gap-3.5">
                                    <div class="w-10 h-10 rounded-xl {{ $isOverdue ? 'bg-orange-50 border border-orange-200/70 text-orange-600' : 'bg-pink-50 border border-pink-200/70 text-pink-600' }} flex items-center justify-center shrink-0">
                                        @if(str_contains($catName, 'olahraga'))
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                                <circle cx="12" cy="12" r="9"></circle>
                                                <path d="M12 3v18"></path>
                                                <path d="M3 12h18"></path>
                                            </svg>
                                        @elseif(str_contains($catName, 'lab'))
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                                <path d="M6 18h8"></path>
                                                <path d="M3 22h18"></path>
                                                <path d="M14 22a7 7 0 1 0 0-14h-1"></path>
                                                <path d="M9 14h2"></path>
                                            </svg>
                                        @else
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                                <rect height="12" rx="2" width="20" x="2" y="6"></rect>
                                                <circle cx="8" cy="12" r="2"></circle>
                                                <path d="M16 10h2"></path>
                                                <path d="M16 14h2"></path>
                                            </svg>
                                        @endif
                                    </div>
                                    <div>
                                        <span class="font-bold text-slate-900 group-hover:text-pink-600 transition-colors block text-xs sm:text-sm">
                                            {{ $loan->item->name ?? '-' }}
                                        </span>
                                        <span class="font-mono text-[11px] text-slate-500 bg-slate-100 px-1.5 py-0.5 rounded border border-slate-200/60 inline-block mt-0.5">
                                            {{ $loan->item->code ?? '-' }}
                                        </span>
                                    </div>
                                </div>
                            </td>
                            <td class="py-4 px-6 font-semibold text-slate-800">
                                {{ number_format($loan->quantity, 0, ',', '.') }} <span class="font-normal text-slate-500">Unit</span>
                            </td>
                            <td class="py-4 px-6 text-slate-600">
                                {{ $loan->loan_date ? $loan->loan_date->translatedFormat('d M Y') : '-' }}
                            </td>
                            <td class="py-4 px-6">
                                @if($isOverdue)
                                    <div class="font-bold text-rose-600 flex items-center gap-1.5">
                                        <svg class="w-3.5 h-3.5 text-rose-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <circle cx="12" cy="12" r="10"></circle>
                                            <line x1="12" x2="12" y1="8" y2="12"></line>
                                            <line x1="12" x2="12.01" y1="16" y2="16"></line>
                                        </svg>
                                        {{ $loan->due_date ? $loan->due_date->translatedFormat('d M Y') : '-' }}
                                    </div>
                                    <div class="text-[11px] text-rose-600/90 font-medium">Lewat tempo {{ $daysDiff }} hari</div>
                                @else
                                    <div class="font-bold text-slate-800 flex items-center gap-1.5">
                                        <svg class="w-3.5 h-3.5 text-pink-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <circle cx="12" cy="12" r="10"></circle>
                                            <polyline points="12 6 12 12 16 14"></polyline>
                                        </svg>
                                        {{ $loan->due_date ? $loan->due_date->translatedFormat('d M Y') : '-' }}
                                    </div>
                                    <div class="text-[11px] text-emerald-600 font-medium">Sisa {{ $daysDiff }} hari lagi</div>
                                @endif
                            </td>
                            <td class="py-4 px-6">
                                @if($isOverdue)
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-bold bg-rose-50 text-rose-700 border border-rose-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-rose-600 animate-ping"></span>
                                        Terlambat
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200/80">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                        Dipinjam (Aktif)
                                    </span>
                                @endif
                            </td>
                            <td class="py-4 px-6 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('loans.show', $loan) }}" class="px-2.5 py-1.5 text-xs font-medium text-slate-600 hover:text-slate-900 bg-slate-100 hover:bg-slate-200 rounded-lg transition-colors">
                                        Detail
                                    </a>
                                    <a href="{{ route('loans.show', $loan) }}" class="px-3 py-1.5 text-xs font-semibold {{ $isOverdue ? 'text-rose-700 hover:bg-rose-700 hover:text-white bg-rose-50 border border-rose-200/90' : 'text-pink-700 hover:bg-pink-50 border border-pink-200' }} rounded-lg transition-all">
                                        {{ $isOverdue ? 'Kembalikan Sekarang' : 'Perpanjang / Selesai' }}
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-8 px-6 text-center text-slate-500">
                                Anda sedang tidak memiliki tanggungan peminjaman barang.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
    <!-- END: Active Borrowings Table Section -->

    <!-- BEGIN: Refined Catalog Section -->
    <section class="space-y-4 pt-2" data-purpose="available-catalog-section" id="katalog">
        <!-- Search, Header & Category Pills -->
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
            <div>
                <div class="flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-pink-500"></span>
                    <h2 class="text-base sm:text-lg font-bold tracking-tight text-slate-900">Katalog Sarana & Fasilitas Tersedia</h2>
                </div>
                <p class="text-xs text-slate-500 mt-0.5">Pilih inventaris praktik kejuruan atau ekstrakurikuler yang siap dipinjam</p>
            </div>
            <!-- Search Bar with Keyboard Shortcut Pill -->
            <form method="GET" action="{{ route('dashboard') }}#katalog" class="relative w-full sm:w-80">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-slate-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <circle cx="11" cy="11" r="8"></circle>
                        <line x1="21" x2="16.65" y1="21" y2="16.65"></line>
                    </svg>
                </span>
                <input class="w-full pl-9 pr-14 py-2 text-xs bg-white border border-slate-200 rounded-xl focus:ring-2 focus:ring-pink-400 focus:border-pink-400 transition-all shadow-subtle placeholder:text-slate-400" name="search" value="{{ request('search') }}" placeholder="Cari proyektor, laptop, kamera..." type="text"/>
                <span class="absolute inset-y-0 right-0 flex items-center pr-2.5 pointer-events-none">
                    <kbd class="text-[10px] font-mono font-medium text-slate-400 bg-slate-100 border border-slate-200 px-1.5 py-0.5 rounded shadow-xs">⌘K</kbd>
                </span>
            </form>
        </div>

        <!-- Category Filter Pills (Interactive Client-Side & Responsive Mobile Scroll) -->
        <div class="flex items-center gap-2 overflow-x-auto pb-2 pt-1 scrollbar-none select-none" id="category-pills">
            <button type="button" data-category-id="all" onclick="filterCatalog('all', this)" class="category-pill px-4 py-2 rounded-xl text-xs cursor-pointer transition-all duration-200 shrink-0 flex items-center gap-1.5 {{ !request('category_id') ? 'bg-slate-900 text-white shadow-md font-semibold' : 'bg-white hover:bg-slate-100 text-slate-600 border border-slate-200 font-medium' }}">
                <svg class="w-3.5 h-3.5 opacity-80" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <rect height="7" width="7" x="3" y="3"></rect>
                    <rect height="7" width="7" x="14" y="3"></rect>
                    <rect height="7" width="7" x="14" y="14"></rect>
                    <rect height="7" width="7" x="3" y="14"></rect>
                </svg>
                <span>Semua Sarana</span>
            </button>
            @foreach($categories as $cat)
                @php
                    $cName = strtolower($cat->name);
                    $catId = $cat->id;
                @endphp
                <button type="button" data-category-id="{{ $catId }}" onclick="filterCatalog('{{ $catId }}', this)" class="category-pill px-4 py-2 rounded-xl text-xs cursor-pointer transition-all duration-200 shrink-0 flex items-center gap-1.5 {{ request('category_id') == $catId ? 'bg-slate-900 text-white shadow-md font-semibold' : 'bg-white hover:bg-slate-100 text-slate-600 border border-slate-200 font-medium' }}">
                    @if(str_contains($cName, 'lab'))
                        <svg class="w-3.5 h-3.5 opacity-80" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M6 18h8"></path>
                            <path d="M3 22h18"></path>
                            <path d="M14 22a7 7 0 1 0 0-14h-1"></path>
                        </svg>
                    @elseif(str_contains($cName, 'olahraga'))
                        <svg class="w-3.5 h-3.5 opacity-80" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="9"></circle>
                            <path d="M12 3v18"></path>
                            <path d="M3 12h18"></path>
                        </svg>
                    @elseif(str_contains($cName, 'elektronik') || str_contains($cName, 'multimedia'))
                        <svg class="w-3.5 h-3.5 opacity-80" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <rect height="12" rx="2" width="18" x="3" y="4"></rect>
                            <line x1="2" x2="22" y1="20" y2="20"></line>
                        </svg>
                    @elseif(str_contains($cName, 'bersih') || str_contains($cName, 'kebersihan'))
                        <svg class="w-3.5 h-3.5 opacity-80" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M3 21h18"></path>
                            <path d="M12 3v14"></path>
                            <path d="M7 17h10"></path>
                        </svg>
                    @else
                        <svg class="w-3.5 h-3.5 opacity-80" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                    @endif
                    <span>{{ $cat->name }}</span>
                </button>
            @endforeach
        </div>

        <!-- Catalog Cards Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 pt-1" id="catalog-grid">
            @forelse($availableItems as $item)
                @php
                    $catName = strtolower($item->category->name ?? '');
                    $isAudio = str_contains($catName, 'elektronik') || str_contains($catName, 'audio') || str_contains($catName, 'multimedia');
                    $isIT = str_contains($catName, 'komputer') || str_contains($catName, 'it') || str_contains($catName, 'laptop');
                    $isSports = str_contains($catName, 'olahraga');
                    $isLab = str_contains($catName, 'lab') || str_contains($catName, 'laboratorium');
                    $isClean = str_contains($catName, 'bersih') || str_contains($catName, 'kebersihan');
                @endphp
                <article data-category-id="{{ $item->category_id }}" data-search-text="{{ strtolower($item->name . ' ' . $item->code . ' ' . ($item->category->name ?? '')) }}" class="catalog-card group bg-white rounded-2xl border border-slate-200/80 shadow-card hover:shadow-card-hover hover:-translate-y-1 transition-all duration-200 flex flex-col justify-between overflow-hidden">
                    <div class="p-5">
                        <!-- Top Badges -->
                        <div class="flex items-center justify-between gap-2 mb-3">
                            <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-semibold {{ $isAudio ? 'bg-pink-50 text-pink-700 border border-pink-100' : ($isIT ? 'bg-sky-50 text-sky-700 border border-sky-100' : ($isSports ? 'bg-amber-50 text-amber-700 border border-amber-100' : ($isLab ? 'bg-emerald-50 text-emerald-700 border border-emerald-100' : 'bg-slate-100 text-slate-700 border border-slate-200'))) }}">
                                {{ $item->category->name ?? 'Umum' }}
                            </span>
                            <span class="font-mono text-[10px] text-slate-400">{{ $item->code }}</span>
                        </div>

                        <!-- Vector Graphic Box matching Contoh dashboard.html -->
                        <div class="w-full h-32 rounded-xl {{ $isAudio ? 'bg-gradient-to-b from-pink-50/50 to-slate-50/80 hover:border-pink-200' : ($isIT ? 'bg-gradient-to-b from-sky-50/50 to-slate-50/80 hover:border-sky-200' : ($isSports ? 'bg-gradient-to-b from-amber-50/50 to-slate-50/80 hover:border-amber-200' : 'bg-gradient-to-b from-emerald-50/50 to-slate-50/80 hover:border-emerald-200')) }} border border-slate-100 flex flex-col items-center justify-center relative overflow-hidden transition-colors">
                            <div class="w-12 h-12 rounded-2xl bg-white shadow-sm border border-slate-200/60 flex items-center justify-center {{ $isAudio ? 'text-pink-600' : ($isIT ? 'text-sky-600' : ($isSports ? 'text-amber-600' : 'text-emerald-600')) }} group-hover:scale-105 transition-transform">
                                @if($isAudio)
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                        <rect height="10" rx="2" width="20" x="2" y="6"></rect>
                                        <circle cx="8" cy="11" r="2.5"></circle>
                                        <line x1="16" x2="16.01" y1="9" y2="9"></line>
                                        <line x1="18" x2="18.01" y1="9" y2="9"></line>
                                    </svg>
                                @elseif($isIT)
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                        <rect height="12" rx="2" width="18" x="3" y="4"></rect>
                                        <line x1="2" x2="22" y1="20" y2="20"></line>
                                    </svg>
                                @elseif($isSports)
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                        <circle cx="12" cy="12" r="10"></circle>
                                        <path d="M4.93 4.93l4.24 4.24"></path>
                                        <path d="M14.83 9.17l4.24-4.24"></path>
                                    </svg>
                                @elseif($isClean)
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                        <path d="M3 21h18"></path>
                                        <path d="M12 3v14"></path>
                                        <path d="M7 17h10"></path>
                                    </svg>
                                @else
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                        <path d="M6 18h8"></path>
                                        <path d="M3 22h18"></path>
                                        <path d="M14 22a7 7 0 1 0 0-14h-1"></path>
                                    </svg>
                                @endif
                            </div>
                            <div class="mt-2.5 flex items-center gap-1.5 text-[10px] text-slate-500 font-medium">
                                <span class="font-mono">Inventaris Ready</span>
                            </div>
                        </div>

                        <!-- Title & Stock -->
                        <div class="mt-4">
                            <h3 class="font-bold text-slate-900 group-hover:text-pink-600 transition-colors text-sm">
                                {{ $item->name }}
                            </h3>
                            <p class="text-xs text-slate-500 mt-1 flex items-center gap-1.5">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                <span>Tersedia:</span>
                                <span class="font-semibold text-slate-900">{{ number_format($item->stock, 0, ',', '.') }} Unit</span>
                            </p>
                        </div>
                    </div>

                    <!-- Bottom Card Action Bar -->
                    <div class="px-5 py-3 bg-slate-50/60 border-t border-slate-100 flex items-center justify-between">
                        <span class="text-[10px] font-bold tracking-wide uppercase px-2 py-0.5 rounded bg-emerald-50 text-emerald-700 border border-emerald-200/60">
                            {{ $item->condition === 'baik' ? 'Kondisi Prima' : strtoupper($item->condition) }}
                        </span>
                        <a href="{{ route('loans.create', ['item_id' => $item->id]) }}" class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg bg-slate-900 hover:bg-pink-600 text-white text-xs font-semibold transition-all">
                            <span>Pinjam</span>
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="m9 18 6-6-6-6"></path>
                            </svg>
                        </a>
                    </div>
                </article>
            @empty
                <div class="col-span-full py-8 text-center text-slate-500 text-xs">
                    Tidak ada sarana inventaris tersedia yang sesuai pencarian/filter.
                </div>
            @endforelse
            <div id="empty-catalog-msg" class="hidden col-span-full py-12 text-center text-slate-500 text-xs">
                Tidak ada sarana inventaris tersedia yang sesuai kategori / pencarian ini.
            </div>
        </div>
    </section>
    <!-- END: Refined Catalog Section -->

    <!-- Interactive Filter & Keyboard Shortcut Listener -->
    <script data-purpose="catalog-interactive-filters">
        let activeCategoryId = '{{ request('category_id') ?? 'all' }}';

        function filterCatalog(catId, btnEl) {
            activeCategoryId = String(catId);

            // Update active pill button UI styling
            document.querySelectorAll('.category-pill').forEach(btn => {
                btn.classList.remove('bg-slate-900', 'text-white', 'shadow-md', 'font-semibold');
                btn.classList.add('bg-white', 'hover:bg-slate-100', 'text-slate-600', 'border', 'border-slate-200', 'font-medium');
            });

            if (btnEl) {
                btnEl.classList.remove('bg-white', 'hover:bg-slate-100', 'text-slate-600', 'border', 'border-slate-200', 'font-medium');
                btnEl.classList.add('bg-slate-900', 'text-white', 'shadow-md', 'font-semibold');
            }

            applyCatalogFilters();
        }

        function applyCatalogFilters() {
            const searchVal = (document.querySelector('input[name="search"]')?.value || '').toLowerCase().trim();
            const cards = document.querySelectorAll('.catalog-card');
            let visibleCount = 0;

            cards.forEach(card => {
                const cardCatId = String(card.getAttribute('data-category-id'));
                const cardText = card.getAttribute('data-search-text') || '';

                const matchCat = (activeCategoryId === 'all' || activeCategoryId === cardCatId);
                const matchSearch = (!searchVal || cardText.includes(searchVal));

                if (matchCat && matchSearch) {
                    card.classList.remove('hidden');
                    visibleCount++;
                } else {
                    card.classList.add('hidden');
                }
            });

            const emptyMsg = document.getElementById('empty-catalog-msg');
            if (emptyMsg) {
                if (visibleCount === 0) {
                    emptyMsg.classList.remove('hidden');
                } else {
                    emptyMsg.classList.add('hidden');
                }
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.querySelector('input[name="search"]');
            if (searchInput) {
                searchInput.addEventListener('input', applyCatalogFilters);
            }

            if (activeCategoryId !== 'all') {
                const targetBtn = document.querySelector(`.category-pill[data-category-id="${activeCategoryId}"]`);
                if (targetBtn) {
                    filterCatalog(activeCategoryId, targetBtn);
                }
            }

            // Keyboard shortcut ⌘K / Ctrl+K
            document.addEventListener('keydown', function(e) {
                if ((e.metaKey || e.ctrlKey) && e.key.toLowerCase() === 'k') {
                    e.preventDefault();
                    if (searchInput) {
                        searchInput.focus();
                        searchInput.select();
                    }
                }
            });
        });
    </script>
</x-app-layout>
