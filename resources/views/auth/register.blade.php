<x-guest-layout>
    <div class="mb-5 text-center">
        <h2 class="text-xl font-bold text-gray-800">Daftar Akun Pengguna Baru</h2>
        <p class="text-xs text-gray-500 mt-1">Lengkapi formulir di bawah ini untuk membuat akun baru</p>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" value="Nama Lengkap *" />
            <x-text-input id="name" class="block mt-1 w-full text-sm" type="text" name="name" :value="old('name')" placeholder="Contoh: Budi Santoso" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" value="Alamat Email *" />
            <x-text-input id="email" class="block mt-1 w-full text-sm" type="email" name="email" :value="old('email')" placeholder="Contoh: budi@sekolah.sch.id" required autocomplete="username" oninput="this.value = this.value.toLowerCase()" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" value="Password *" />

            <x-text-input id="password" class="block mt-1 w-full text-sm"
                            type="password"
                            name="password"
                            placeholder="Minimal 8 karakter"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" value="Konfirmasi Password *" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full text-sm"
                            type="password"
                            name="password_confirmation"
                            placeholder="Ulangi password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between mt-5 pt-2 border-t border-pink-50">
            <a class="underline text-xs text-gray-600 hover:text-pink-600 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-400" href="{{ route('login') }}">
                Sudah punya akun? Masuk
            </a>

            <x-primary-button class="ms-4 bg-pink-500 hover:bg-pink-600 text-white shadow-md shadow-pink-200">
                Daftar Akun
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
