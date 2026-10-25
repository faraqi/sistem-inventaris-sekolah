<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="mb-4 text-center">
        <h2 class="text-xl font-bold text-gray-800">Masuk ke Sistem Inventaris</h2>
        <p class="text-xs text-gray-500 mt-1">Silakan masukkan email dan password akun Anda</p>
    </div>

    <!-- Quick Demo Credential Autofill Buttons -->
    <div class="mb-6 p-3 bg-orange-50 border border-orange-100 rounded-lg text-xs space-y-2">
        <p class="font-bold text-orange-900">Uji Coba Cepat (Click to Autofill):</p>
        <div class="grid grid-cols-2 gap-2">
            <button type="button" onclick="document.getElementById('email').value='admin@sekolah.sch.id'; document.getElementById('password').value='password';" class="bg-amber-500 hover:bg-amber-600 text-white font-bold py-1.5 px-2 rounded text-[11px] shadow-sm">
                As Admin
            </button>
            <button type="button" onclick="document.getElementById('email').value='siswa@sekolah.sch.id'; document.getElementById('password').value='password';" class="bg-orange-500 hover:bg-orange-600 text-white font-bold py-1.5 px-2 rounded text-[11px] shadow-sm">
                As User (Siswa)
            </button>
        </div>
    </div>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" value="Email *" />
            <x-text-input id="email" class="block mt-1 w-full text-sm" type="email" name="email" :value="old('email')" placeholder="Masukkan email (contoh: admin@sekolah.sch.id)" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" value="Password *" />

            <x-text-input id="password" class="block mt-1 w-full text-sm"
                            type="password"
                            name="password"
                            placeholder="Masukkan password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-orange-600 shadow-sm focus:ring-orange-400" name="remember">
                <span class="ms-2 text-sm text-gray-600">Ingat Saya</span>
            </label>
        </div>

        <div class="flex items-center justify-between mt-4">
            <a class="underline text-xs text-gray-600 hover:text-orange-600 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-400" href="{{ route('register') }}">
                Belum punya akun? Daftar
            </a>

            <x-primary-button class="ms-3 bg-orange-500 hover:bg-orange-600 shadow-orange-200">
                Masuk System
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
