<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-xl text-gray-800 leading-tight">
                Edit Kategori: {{ $category->name }}
            </h2>
            <a href="{{ route('categories.index') }}" class="text-sm text-gray-600 hover:text-orange-600 font-medium transition">&larr; Kembali ke Daftar Kategori</a>
        </div>
    </x-slot>

    <div class="py-6 max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <form method="POST" action="{{ route('categories.update', $category) }}" class="space-y-6">
                @csrf
                @method('PUT')

                <div>
                    <label for="name" class="block text-sm font-semibold text-gray-700 mb-1">
                        Nama Kategori Barang <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" name="name" id="name" value="{{ old('name', $category->name) }}" placeholder="Contoh: Alat Laboratorium, Elektronik..." autofocus required class="w-full rounded-lg border-gray-300 shadow-sm focus:border-orange-400 focus:ring-orange-300 text-sm">
                    @error('name')
                        <p class="text-rose-500 text-xs mt-1 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-end space-x-3 pt-4 border-t border-gray-100">
                    <a href="{{ route('categories.index') }}" class="px-4 py-2 border border-gray-300 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-50">Batal</a>
                    <button type="submit" class="px-5 py-2 bg-orange-500 hover:bg-orange-600 text-white font-bold text-sm rounded-lg shadow-md shadow-orange-200 transition">Perbarui Kategori</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
