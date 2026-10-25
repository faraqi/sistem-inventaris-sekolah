<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-xl text-gray-800 leading-tight">
                Tambah Akun Pengguna Baru
            </h2>
            <a href="{{ route('users.index') }}" class="text-sm text-gray-600 hover:text-pink-600 font-medium transition">&larr; Kembali ke Daftar User</a>
        </div>
    </x-slot>

    <div class="py-6 max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <form method="POST" action="{{ route('users.store') }}" class="space-y-5">
                @csrf

                <!-- Name -->
                <div>
                    <label for="name" class="block text-sm font-semibold text-gray-700 mb-1">
                        Nama Lengkap <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" placeholder="Contoh: Ahmad Subagyo, S.Pd" autofocus required class="w-full rounded-lg border-gray-300 shadow-sm focus:border-pink-400 focus:ring-pink-300 text-sm">
                    @error('name')
                        <p class="text-rose-500 text-xs mt-1 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-semibold text-gray-700 mb-1">
                        Alamat Email <span class="text-rose-500">*</span>
                    </label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" placeholder="Contoh: ahmad@sekolah.sch.id" required class="w-full rounded-lg border-gray-300 shadow-sm focus:border-pink-400 focus:ring-pink-300 text-sm">
                    @error('email')
                        <p class="text-rose-500 text-xs mt-1 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Role & Password Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Role -->
                    <div>
                        <label for="role" class="block text-sm font-semibold text-gray-700 mb-1">
                            Role Hak Akses <span class="text-rose-500">*</span>
                        </label>
                        <select name="role" id="role" required class="w-full rounded-lg border-gray-300 shadow-sm focus:border-pink-400 focus:ring-pink-300 text-sm">
                            <option value="user" {{ old('role') === 'user' ? 'selected' : '' }}>User (Guru / Siswa)</option>
                            <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Admin (Pengelola Inventaris)</option>
                        </select>
                        @error('role')
                            <p class="text-rose-500 text-xs mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-semibold text-gray-700 mb-1">
                            Password Login <span class="text-rose-500">*</span>
                        </label>
                        <input type="password" name="password" id="password" placeholder="Minimal 8 karakter" required class="w-full rounded-lg border-gray-300 shadow-sm focus:border-pink-400 focus:ring-pink-300 text-sm">
                        @error('password')
                            <p class="text-rose-500 text-xs mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex items-center justify-end space-x-3 pt-4 border-t border-gray-100">
                    <a href="{{ route('users.index') }}" class="px-4 py-2 border border-gray-300 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-50">Batal</a>
                    <button type="submit" class="px-5 py-2 bg-pink-500 hover:bg-pink-600 text-white font-bold text-sm rounded-lg shadow-md shadow-pink-200 transition">Simpan User</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
