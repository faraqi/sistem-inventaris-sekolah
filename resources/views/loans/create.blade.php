<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-xl text-gray-800 leading-tight">
                Form Pengajuan Peminjaman Barang
            </h2>
            <a href="{{ route('loans.index') }}" class="text-sm text-gray-600 hover:text-orange-600 font-medium transition">&larr; Kembali ke Riwayat Peminjaman</a>
        </div>
    </x-slot>

    <div class="py-6 max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <form method="POST" action="{{ route('loans.store') }}" class="space-y-5">
                @csrf

                @if(Auth::user()->isAdmin())
                    <!-- Select Borrower User (Admin Only) -->
                    <div>
                        <label for="user_id" class="block text-sm font-semibold text-gray-700 mb-1">
                            Pilih Peminjam (Guru / Siswa) <span class="text-rose-500">*</span>
                        </label>
                        <select name="user_id" id="user_id" autofocus required class="w-full rounded-lg border-gray-300 shadow-sm focus:border-orange-400 focus:ring-orange-300 text-sm">
                            <option value="">-- Pilih Akun User --</option>
                            @foreach($users as $u)
                                <option value="{{ $u->id }}" {{ old('user_id') == $u->id ? 'selected' : '' }}>
                                    {{ $u->name }} ({{ $u->email }})
                                </option>
                            @endforeach
                        </select>
                        @error('user_id')
                            <p class="text-rose-500 text-xs mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>
                @endif

                <!-- Select Item -->
                <div>
                    <label for="item_id" class="block text-sm font-semibold text-gray-700 mb-1">
                        Pilih Barang Inventaris <span class="text-rose-500">*</span>
                    </label>
                    <select name="item_id" id="item_id" {{ !Auth::user()->isAdmin() ? 'autofocus' : '' }} required class="w-full rounded-lg border-gray-300 shadow-sm focus:border-orange-400 focus:ring-orange-300 text-sm">
                        <option value="">-- Pilih Barang yang Tersedia --</option>
                        @foreach($items as $item)
                            <option value="{{ $item->id }}" {{ old('item_id', $selectedItem?->id) == $item->id ? 'selected' : '' }}>
                                {{ $item->name }} ({{ $item->code }}) - Stok: {{ $item->stock }} unit [Kondisi: {{ strtoupper($item->condition) }}]
                            </option>
                        @endforeach
                    </select>
                    @error('item_id')
                        <p class="text-rose-500 text-xs mt-1 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Quantity -->
                <div>
                    <label for="quantity" class="block text-sm font-semibold text-gray-700 mb-1">
                        Jumlah Barang Dipinjam <span class="text-rose-500">*</span>
                    </label>
                    <input type="number" name="quantity" id="quantity" value="{{ old('quantity', 1) }}" min="1" placeholder="Contoh: 1" required class="w-full rounded-lg border-gray-300 shadow-sm focus:border-orange-400 focus:ring-orange-300 text-sm">
                    @error('quantity')
                        <p class="text-rose-500 text-xs mt-1 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Loan Date & Due Date Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Loan Date -->
                    <div>
                        <label for="loan_date" class="block text-sm font-semibold text-gray-700 mb-1">
                            Tanggal Peminjaman <span class="text-rose-500">*</span>
                        </label>
                        <input type="date" name="loan_date" id="loan_date" value="{{ old('loan_date', date('Y-m-d')) }}" required class="w-full rounded-lg border-gray-300 shadow-sm focus:border-orange-400 focus:ring-orange-300 text-sm">
                        @error('loan_date')
                            <p class="text-rose-500 text-xs mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Due Date -->
                    <div>
                        <label for="due_date" class="block text-sm font-semibold text-gray-700 mb-1">
                            Batas Waktu Pengembalian <span class="text-rose-500">*</span>
                        </label>
                        <input type="date" name="due_date" id="due_date" value="{{ old('due_date', date('Y-m-d', strtotime('+3 days'))) }}" required class="w-full rounded-lg border-gray-300 shadow-sm focus:border-orange-400 focus:ring-orange-300 text-sm">
                        @error('due_date')
                            <p class="text-rose-500 text-xs mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex items-center justify-end space-x-3 pt-4 border-t border-gray-100">
                    <a href="{{ route('loans.index') }}" class="px-4 py-2 border border-gray-300 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-50">Batal</a>
                    <button type="submit" class="px-5 py-2 bg-orange-500 hover:bg-orange-600 text-white font-bold text-sm rounded-lg shadow-md shadow-orange-200 transition">Ajukan Peminjaman</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
