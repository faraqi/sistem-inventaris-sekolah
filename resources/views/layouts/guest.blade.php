<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-[#fff5f7]">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Inventaris Sekolah - SMKN 1 KETAPANG') }}</title>

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
                    indigo: {
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
        <style>
            .bg-grid-pattern {
                background-image: radial-gradient(rgba(244, 114, 182, 0.22) 1px, transparent 1px);
                background-size: 24px 24px;
            }
        </style>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-slate-800 antialiased selection:bg-pink-400 selection:text-white bg-[#fff5f7] bg-grid-pattern min-h-screen flex flex-col justify-center items-center py-8 px-4">
        <div class="w-full sm:max-w-md flex flex-col items-center">
            <a href="/" class="mb-5 flex items-center gap-3 group">
                <div class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-pink-500 to-rose-400 text-white flex items-center justify-center shadow-lg shadow-pink-500/25 group-hover:scale-105 transition-transform">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path>
                        <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
                        <line x1="12" x2="12" y1="22.08" y2="12"></line>
                    </svg>
                </div>
                <div class="text-left">
                    <span class="text-base font-extrabold tracking-wider text-slate-900 block leading-tight">INVENTARIS SEKOLAH</span>
                    <span class="text-xs text-pink-600 font-semibold">SMKN 1 KETAPANG</span>
                </div>
            </a>

            <div class="w-full bg-white/95 backdrop-blur-xl border border-pink-100/90 shadow-xl shadow-pink-500/5 rounded-2xl p-6 sm:p-8">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
