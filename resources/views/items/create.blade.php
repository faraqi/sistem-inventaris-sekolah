<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-xl text-gray-800 leading-tight">
                Tambah Barang Inventaris Baru
            </h2>
            <a href="{{ route('items.index') }}" class="text-sm text-gray-600 hover:text-pink-600 font-medium transition">&larr; Kembali ke Katalog Barang</a>
        </div>
    </x-slot>

    <div class="py-6 max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <form method="POST" action="{{ route('items.store') }}" class="space-y-5">
                @csrf

                <!-- Category -->
                <div>
                    <label for="category_id" class="block text-sm font-semibold text-gray-700 mb-1">
                        Kategori Barang <span class="text-rose-500">*</span>
                    </label>
                    <select name="category_id" id="category_id" autofocus required class="w-full rounded-lg border-gray-300 shadow-sm focus:border-pink-400 focus:ring-pink-300 text-sm">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="text-rose-500 text-xs mt-1 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Name -->
                <div>
                    <label for="name" class="block text-sm font-semibold text-gray-700 mb-1">
                        Nama Barang <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" placeholder="Contoh: Proyektor Epson, Bola Basket Molten..." required class="w-full rounded-lg border-gray-300 shadow-sm focus:border-pink-400 focus:ring-pink-300 text-sm">
                    @error('name')
                        <p class="text-rose-500 text-xs mt-1 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Code & Stock Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Code SKU -->
                    <div>
                        <label for="code" class="block text-sm font-semibold text-gray-700 mb-1">
                            Kode Barang / SKU <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" name="code" id="code" value="{{ old('code') }}" placeholder="Contoh: ELK-PRO-001" required class="w-full rounded-lg border-gray-300 shadow-sm focus:border-pink-400 focus:ring-pink-300 text-sm uppercase font-mono">
                        @error('code')
                            <p class="text-rose-500 text-xs mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Stock -->
                    <div>
                        <label for="stock" class="block text-sm font-semibold text-gray-700 mb-1">
                            Jumlah Stok Tersedia <span class="text-rose-500">*</span>
                        </label>
                        <input type="number" name="stock" id="stock" value="{{ old('stock', 1) }}" min="0" placeholder="Contoh: 10" required class="w-full rounded-lg border-gray-300 shadow-sm focus:border-pink-400 focus:ring-pink-300 text-sm">
                        @error('stock')
                            <p class="text-rose-500 text-xs mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Condition -->
                <div>
                    <label for="condition" class="block text-sm font-semibold text-gray-700 mb-1">
                        Kondisi Barang Saat Ini <span class="text-rose-500">*</span>
                    </label>
                    <select name="condition" id="condition" required class="w-full rounded-lg border-gray-300 shadow-sm focus:border-pink-400 focus:ring-pink-300 text-sm">
                        <option value="baik" {{ old('condition') === 'baik' ? 'selected' : '' }}>Baik (Siap Pakai)</option>
                        <option value="rusak ringan" {{ old('condition') === 'rusak ringan' ? 'selected' : '' }}>Rusak Ringan</option>
                        <option value="rusak berat" {{ old('condition') === 'rusak berat' ? 'selected' : '' }}>Rusak Berat</option>
                    </select>
                    @error('condition')
                        <p class="text-rose-500 text-xs mt-1 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Form Footer -->
                <div class="flex items-center justify-end space-x-3 pt-4 border-t border-gray-100">
                    <a href="{{ route('items.index') }}" class="px-4 py-2 border border-gray-300 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-50">Batal</a>
                    <button type="submit" class="px-5 py-2 bg-pink-500 hover:bg-pink-600 text-white font-bold text-sm rounded-lg shadow-md shadow-pink-200 transition">Simpan Barang</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
