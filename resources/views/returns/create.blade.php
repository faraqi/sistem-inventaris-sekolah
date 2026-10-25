<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-xl text-gray-800 leading-tight">
                Verifikasi & Catat Pengembalian Barang
            </h2>
            <a href="{{ route('returns.index') }}" class="text-sm text-gray-600 hover:text-gray-900 font-medium">&larr; Kembali ke Riwayat Pengembalian</a>
        </div>
    </x-slot>

    <div class="py-6 max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <form method="POST" action="{{ route('returns.store') }}" class="space-y-5">
                @csrf

                <!-- Select Active Loan -->
                <div>
                    <label for="loan_id" class="block text-sm font-semibold text-gray-700 mb-1">
                        Pilih Transaksi Peminjaman <span class="text-rose-500">*</span>
                    </label>
                    <select name="loan_id" id="loan_id" autofocus required class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                        <option value="">-- Pilih Peminjaman yang Aktif --</option>
                        @foreach($activeLoans as $loan)
                            <option value="{{ $loan->id }}" {{ old('loan_id', $selectedLoan?->id) == $loan->id ? 'selected' : '' }}>
                                TRX #{{ $loan->id }} - {{ $loan->user->name }} (Meminjam {{ $loan->quantity }} unit {{ $loan->item->name }}) - Batas: {{ $loan->due_date ? $loan->due_date->format('d/m/Y') : '-' }}
                            </option>
                        @endforeach
                    </select>
                    @error('loan_id')
                        <p class="text-rose-500 text-xs mt-1 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Returned At -->
                <div>
                    <label for="returned_at" class="block text-sm font-semibold text-gray-700 mb-1">
                        Tanggal Dikembalikan <span class="text-rose-500">*</span>
                    </label>
                    <input type="date" name="returned_at" id="returned_at" value="{{ old('returned_at', date('Y-m-d')) }}" required class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                    @error('returned_at')
                        <p class="text-rose-500 text-xs mt-1 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Condition on Return -->
                <div>
                    <label for="condition_on_return" class="block text-sm font-semibold text-gray-700 mb-1">
                        Kondisi Barang Saat Dikembalikan <span class="text-rose-500">*</span>
                    </label>
                    <select name="condition_on_return" id="condition_on_return" required class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                        <option value="baik" {{ old('condition_on_return') === 'baik' ? 'selected' : '' }}>Baik (Lengkap & Berfungsi)</option>
                        <option value="rusak ringan" {{ old('condition_on_return') === 'rusak ringan' ? 'selected' : '' }}>Rusak Ringan (Ada lecet / kelengkapan berkurang)</option>
                        <option value="rusak berat" {{ old('condition_on_return') === 'rusak berat' ? 'selected' : '' }}>Rusak Berat / Perlu Perbaikan</option>
                    </select>
                    @error('condition_on_return')
                        <p class="text-rose-500 text-xs mt-1 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Notes -->
                <div>
                    <label for="notes" class="block text-sm font-semibold text-gray-700 mb-1">
                        Catatan Tambahan dari Admin
                    </label>
                    <textarea name="notes" id="notes" rows="3" placeholder="Masukkan catatan kondisi fisik, kelengkapan aksesoris, atau kelambatan pengembalian..." class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">{{ old('notes') }}</textarea>
                    @error('notes')
                        <p class="text-rose-500 text-xs mt-1 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-end space-x-3 pt-4 border-t border-gray-100">
                    <a href="{{ route('returns.index') }}" class="px-4 py-2 border border-gray-300 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-50">Batal</a>
                    <button type="submit" class="px-5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-sm rounded-lg shadow">Verifikasi & Simpan Pengembalian</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
