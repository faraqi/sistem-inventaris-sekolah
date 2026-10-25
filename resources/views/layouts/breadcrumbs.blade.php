@php
    $home = ['Dashboard', 'dashboard'];

    $crumbMap = [
        'dashboard'         => [$home],

        'items.index'       => [$home, ['Katalog Barang', 'items.index']],
        'items.show'        => [$home, ['Katalog Barang', 'items.index'], ['Detail Barang', null]],
        'items.create'      => [$home, ['Katalog Barang', 'items.index'], ['Tambah Barang', null]],
        'items.edit'        => [$home, ['Katalog Barang', 'items.index'], ['Edit Barang', null]],

        'loans.index'       => [$home, ['Peminjaman', 'loans.index']],
        'loans.create'      => [$home, ['Peminjaman', 'loans.index'], ['Ajukan Peminjaman', null]],
        'loans.show'        => [$home, ['Peminjaman', 'loans.index'], ['Detail Peminjaman', null]],
        'loans.report'      => [$home, ['Peminjaman', 'loans.index'], ['Laporan Peminjaman', null]],

        'categories.index'  => [$home, ['Kategori', 'categories.index']],
        'categories.create' => [$home, ['Kategori', 'categories.index'], ['Tambah Kategori', null]],
        'categories.edit'   => [$home, ['Kategori', 'categories.index'], ['Edit Kategori', null]],

        'returns.index'     => [$home, ['Pengembalian', 'returns.index']],
        'returns.create'    => [$home, ['Pengembalian', 'returns.index'], ['Catat Pengembalian', null]],
        'returns.show'      => [$home, ['Pengembalian', 'returns.index'], ['Detail Pengembalian', null]],

        'users.index'       => [$home, ['Manajemen User', 'users.index']],
        'users.create'      => [$home, ['Manajemen User', 'users.index'], ['Tambah User', null]],
        'users.edit'        => [$home, ['Manajemen User', 'users.index'], ['Edit User', null]],

        'activity_logs.index' => [$home, ['Activity Log', 'activity_logs.index']],

        'profile.edit'      => [$home, ['Profil Akun', null]],
    ];

    $trail = $crumbMap[request()->route()?->getName()] ?? null;
@endphp

@if($trail)
    <nav aria-label="Breadcrumb" class="breadcrumb max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full mt-4">
        <ol class="flex flex-wrap items-center gap-x-1.5 gap-y-1 text-xs text-slate-500">
            @foreach($trail as $index => $crumb)
                @if($index > 0)
                    <li aria-hidden="true" class="text-slate-300">/</li>
                @endif
                <li>
                    @if($crumb[1] && ! $loop->last)
                        <a href="{{ route($crumb[1]) }}" class="font-medium hover:text-indigo-600 transition-colors">{{ $crumb[0] }}</a>
                    @else
                        <span aria-current="page" class="font-semibold text-slate-800">{{ $crumb[0] }}</span>
                    @endif
                </li>
            @endforeach
        </ol>
    </nav>
@endif
