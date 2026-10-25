<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Inventaris Sekolah - SMKN 1 Ketapang</title>

    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script>
        tailwind.config = {
          theme: {
            extend: {
              fontFamily: {
                sans: ['"Plus Jakarta Sans"', 'system-ui', 'sans-serif'],
              },
              colors: {
                primary: {
                  50: '#fff1f5',
                  100: '#ffe4ec',
                  200: '#fecdd9',
                  300: '#fda4be',
                  400: '#fb7199',
                  500: '#ec4899',
                  600: '#db2777',
                  700: '#be185d',
                  800: '#9d174d',
                  900: '#831843',
                },
                pink: {
                  50: '#fff1f5',
                  100: '#ffe4ec',
                  200: '#fecdd9',
                  300: '#fda4be',
                  400: '#fb7199',
                  500: '#ec4899',
                  600: '#db2777',
                  700: '#be185d',
                  800: '#9d174d',
                  900: '#831843',
                }
              }
            }
          }
        }
    </script>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#140b13] text-slate-100 font-sans min-h-screen flex flex-col justify-between selection:bg-pink-400 selection:text-white relative overflow-x-hidden">

    <!-- Ambient Soft Pink Glow Backdrops -->
    <div class="absolute -top-40 left-1/2 -translate-x-1/2 w-[700px] h-[400px] bg-gradient-to-b from-pink-500/20 via-rose-500/10 to-transparent blur-3xl pointer-events-none"></div>

    <!-- Navbar Header -->
    <header class="relative z-10 max-w-7xl mx-auto px-6 py-6 w-full flex items-center justify-between">
        <div class="flex items-center space-x-3">
            <div class="bg-gradient-to-tr from-pink-500 to-rose-400 p-2.5 rounded-xl shadow-lg shadow-pink-500/30 text-white">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                </svg>
            </div>
            <div>
                <h1 class="font-extrabold text-xl tracking-tight text-white">INVENTARIS SEKOLAH</h1>
                <p class="text-xs text-pink-300/80">SMKN 1 KETAPANG • Pink Edition</p>
            </div>
        </div>

        <div>
            @auth
                <a href="{{ url('/dashboard') }}" class="bg-gradient-to-r from-pink-500 to-rose-500 hover:from-pink-600 hover:to-rose-600 text-white font-bold text-sm px-5 py-2.5 rounded-xl shadow-lg shadow-pink-500/25 transition">
                    Buka Dashboard &rarr;
                </a>
            @else
                <a href="{{ route('login') }}" class="bg-gradient-to-r from-pink-500 to-rose-500 hover:from-pink-600 hover:to-rose-600 text-white font-bold text-sm px-5 py-2.5 rounded-xl shadow-lg shadow-pink-500/25 transition">
                    Masuk (Login)
                </a>
            @endauth
        </div>
    </header>

    <!-- Main Hero -->
    <main class="relative z-10 max-w-7xl mx-auto px-6 py-12 w-full grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
        <!-- Hero Text -->
        <div class="lg:col-span-7 space-y-6">
            <span class="px-3.5 py-1.5 bg-pink-500/15 text-pink-300 border border-pink-500/30 rounded-full text-xs font-bold uppercase tracking-wider inline-flex items-center gap-1.5">
                <span class="w-1.5 h-1.5 rounded-full bg-pink-400 animate-pulse"></span>
                Digital Inventory System • Soft Pink
            </span>
            <h2 class="text-4xl lg:text-5xl font-extrabold text-white leading-tight">
                Kelola & Pinjam Barang Inventaris Sekolah Secara <span class="text-transparent bg-clip-text bg-gradient-to-r from-pink-400 via-rose-300 to-pink-200">Digital & Terpusat</span>
            </h2>
            <p class="text-pink-100/80 text-base leading-relaxed">
                Solusi modern untuk mencatat data barang, kategori, peminjaman, serta pengembalian inventaris laboratorium, olahraga, dan elektronik sekolah secara real-time.
            </p>

            <div class="pt-4 flex flex-wrap gap-4">
                @auth
                    <a href="{{ route('dashboard') }}" class="bg-gradient-to-r from-pink-500 to-rose-500 hover:from-pink-600 hover:to-rose-600 text-white font-extrabold text-base px-6 py-3.5 rounded-xl shadow-xl shadow-pink-600/30 transition">
                        Ke Dashboard Sistem
                    </a>
                @else
                    <a href="{{ route('login') }}" class="bg-gradient-to-r from-pink-500 to-rose-500 hover:from-pink-600 hover:to-rose-600 text-white font-extrabold text-base px-6 py-3.5 rounded-xl shadow-xl shadow-pink-600/30 transition">
                        Login Sekarang
                    </a>
                    <a href="{{ route('register') }}" class="bg-[#241322] hover:bg-[#2d182b] text-pink-200 border border-pink-500/20 font-bold text-base px-6 py-3.5 rounded-xl transition">
                        Daftar Akun Baru
                    </a>
                @endauth
            </div>
        </div>

        <!-- Quick Demo Credentials Box -->
        <div class="lg:col-span-5 bg-[#20101e]/80 border border-pink-500/20 rounded-2xl p-6 shadow-2xl backdrop-blur-md space-y-4">
            <div class="flex items-center space-x-2 text-pink-400 font-bold text-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 0121 9z" />
                </svg>
                <span>Akun Testing (Demo Credentials)</span>
            </div>

            <p class="text-xs text-pink-200/70">Gunakan akun berikut untuk menguji coba hak akses role di dalam sistem:</p>

            <div class="space-y-3">
                <!-- Admin Card -->
                <div class="bg-[#170a16] border border-pink-500/20 p-3.5 rounded-xl text-xs space-y-1">
                    <div class="flex items-center justify-between">
                        <span class="font-extrabold text-pink-400 uppercase">AKUN ADMIN (Pengelola)</span>
                        <span class="text-slate-400 font-mono">Password: password</span>
                    </div>
                    <p class="text-slate-200 font-mono">Email: <strong>admin@sekolah.sch.id</strong></p>
                    <p class="text-slate-400 text-[11px]">Akses penuh: Kelola Kategori, Barang, Verifikasi Peminjaman & Return, User, Activity Log.</p>
                </div>

                <!-- User Card -->
                <div class="bg-[#170a16] border border-pink-500/20 p-3.5 rounded-xl text-xs space-y-1">
                    <div class="flex items-center justify-between">
                        <span class="font-extrabold text-emerald-400 uppercase">AKUN USER (Siswa / Guru)</span>
                        <span class="text-slate-400 font-mono">Password: password</span>
                    </div>
                    <p class="text-slate-200 font-mono">Email: <strong>siswa@sekolah.sch.id</strong> / <strong>guru@sekolah.sch.id</strong></p>
                    <p class="text-slate-400 text-[11px]">Akses user: Katalog Barang, Pengajuan Peminjaman, Riwayat Peminjaman Pribadi.</p>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="relative z-10 max-w-7xl mx-auto px-6 py-6 w-full text-center text-xs text-pink-300/60 border-t border-pink-500/20">
        &copy; {{ date('Y') }} Sistem Inventaris Sekolah - SMKN 1 KETAPANG
    </footer>

</body>
</html>
