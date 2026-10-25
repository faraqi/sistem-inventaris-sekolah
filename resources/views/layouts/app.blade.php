<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-[#f8fafc] antialiased">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Inventaris Sekolah - SMKN 1 KETAPANG') }}</title>

    <!-- Google Fonts: Plus Jakarta Sans & JetBrains Mono -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">

    <!-- Tailwind CSS CDN with forms and container queries plugins -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>

    <!-- Tailwind Configuration matching Contoh dashboard.html -->
    <script>
        tailwind.config = {
          theme: {
            extend: {
              fontFamily: {
                sans: ['"Plus Jakarta Sans"', 'system-ui', '-apple-system', 'sans-serif'],
                mono: ['"JetBrains Mono"', 'monospace']
              },
              colors: {
                slate: {
                  850: '#151f32',
                  900: '#0f172a',
                  950: '#090d16',
                },
                primary: {
                  50: '#eef2ff',
                  100: '#e0e7ff',
                  200: '#c7d2fe',
                  500: '#6366f1',
                  600: '#4f46e5',
                  700: '#4338ca',
                  800: '#3730a3',
                  900: '#312e81',
                }
              },
              boxShadow: {
                'subtle': '0 1px 2px 0 rgba(0, 0, 0, 0.03), 0 1px 3px 0 rgba(0, 0, 0, 0.04)',
                'card': '0 1px 3px 0 rgba(15, 23, 42, 0.04), 0 4px 12px -2px rgba(15, 23, 42, 0.03)',
                'card-hover': '0 10px 25px -4px rgba(15, 23, 42, 0.06), 0 4px 10px -2px rgba(15, 23, 42, 0.03)',
                'float': '0 20px 35px -8px rgba(15, 23, 42, 0.08), 0 8px 16px -4px rgba(15, 23, 42, 0.03)',
                'glow-primary': '0 0 24px -4px rgba(79, 70, 229, 0.28)',
              }
            }
          }
        }
    </script>

    <style>
        .bg-grid-pattern {
            background-image: radial-gradient(rgba(148, 163, 184, 0.18) 1px, transparent 1px);
            background-size: 24px 24px;
        }
        .btn-shine {
            position: relative;
            overflow: hidden;
        }
        .btn-shine::after {
            content: '';
            position: absolute;
            top: -50%;
            left: -60%;
            width: 40%;
            height: 200%;
            background: linear-gradient(
                60deg,
                rgba(255, 255, 255, 0) 20%,
                rgba(255, 255, 255, 0.25) 50%,
                rgba(255, 255, 255, 0) 80%
            );
            transform: rotate(25deg);
            transition: all 0.75s ease;
        }
        .btn-shine:hover::after {
            left: 130%;
        }
    </style>

    <!-- Alpine JS via Breeze -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-[#f8fafc] text-slate-800 antialiased flex flex-col font-sans selection:bg-indigo-500 selection:text-white bg-grid-pattern">

    @include('layouts.navigation')

    <!-- Flash Notifications -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full mt-4">
        @if(session('success'))
            <div class="bg-emerald-50 border border-emerald-200 p-4 rounded-xl shadow-subtle mb-2 flex items-center justify-between">
                <div class="flex items-center space-x-3 text-emerald-800 font-semibold text-xs">
                    <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>{{ session('success') }}</span>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-rose-50 border border-rose-200 p-4 rounded-xl shadow-subtle mb-2 flex items-center justify-between">
                <div class="flex items-center space-x-3 text-rose-800 font-semibold text-xs">
                    <svg class="w-5 h-5 text-rose-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>{{ session('error') }}</span>
                </div>
            </div>
        @endif
    </div>

    <!-- Breadcrumbs -->
    @include('layouts.breadcrumbs')

    <!-- Page Header Slot -->
    @isset($header)
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full mt-4">
            <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-100 [&>div]:flex-wrap [&>div]:gap-3">
                {{ $header }}
            </div>
        </div>
    @endisset

    <!-- Main Page Slot -->
    <main class="flex-1 max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 pt-7 pb-20 md:pb-7 space-y-7">
        {{ $slot }}
    </main>

    <!-- Footer matching Contoh dashboard.html -->
    <footer class="mt-auto border-t border-slate-200/80 bg-white/70 backdrop-blur-md py-6 mb-16 md:mb-0">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row items-center justify-between gap-4 text-xs text-slate-500">
            <div class="flex flex-wrap items-center gap-2 text-center md:text-left">
                <span class="font-bold text-slate-800 tracking-tight">SISTEM INVENTARIS SEKOLAH</span>
                <span class="text-slate-300">•</span>
                <span>SMKN 1 KETAPANG © {{ date('Y') }}</span>
                <span class="text-slate-300 hidden sm:inline">•</span>
                <span class="text-slate-400 hidden sm:inline">Jam Operasional: 07.00 - 16.00 WIB</span>
            </div>
            <div class="flex items-center gap-5">
                <div class="flex items-center gap-1.5 font-medium text-emerald-600 bg-emerald-50 px-2.5 py-1 rounded-full border border-emerald-200/70">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                    <span>Sistem Sinkron</span>
                </div>
            </div>
        </div>
    <!-- Top Progress Bar for Instant Page Navigation Feedback -->
    <div id="instant-progress" class="fixed top-0 left-0 right-0 z-50 h-1 bg-gradient-to-r from-indigo-500 via-purple-500 to-emerald-500 opacity-0 transition-opacity duration-200 pointer-events-none">
        <div class="h-full bg-white/40 w-full animate-pulse"></div>
    </div>

    <!-- Instant SPA Link Engine for 0ms Delay Mobile Navigation -->
    <script data-purpose="instant-navigation-engine">
        (function() {
            const cache = new Map();

            function prefetch(url) {
                if (!url || cache.has(url) || url.includes('#') || url.includes('logout')) return;
                fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                    .then(res => res.text())
                    .then(html => cache.set(url, html))
                    .catch(() => {});
            }

            function showLoading() {
                const bar = document.getElementById('instant-progress');
                if (bar) bar.style.opacity = '1';
            }

            function hideLoading() {
                const bar = document.getElementById('instant-progress');
                if (bar) bar.style.opacity = '0';
            }

            document.addEventListener('touchstart', function(e) {
                const a = e.target.closest('a');
                if (a && a.href && a.origin === window.location.origin) {
                    prefetch(a.href);
                }
            }, { passive: true });

            document.addEventListener('mouseover', function(e) {
                const a = e.target.closest('a');
                if (a && a.href && a.origin === window.location.origin) {
                    prefetch(a.href);
                }
            });

            document.addEventListener('click', function(e) {
                const a = e.target.closest('a');
                if (!a || !a.href || a.origin !== window.location.origin || a.target === '_blank' || a.href.includes('logout') || a.getAttribute('onclick')) return;

                const targetUrl = a.href;
                if (targetUrl === window.location.href) {
                    e.preventDefault();
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                    return;
                }

                // If cached or local route, do instant swap
                e.preventDefault();
                showLoading();

                const loadPage = (html) => {
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');

                    // Update Body Content synchronously
                    if (doc.body) {
                        document.body.innerHTML = doc.body.innerHTML;
                    }

                    // Update Title & URL History
                    if (doc.title) document.title = doc.title;
                    window.history.pushState({}, '', targetUrl);

                    window.scrollTo({ top: 0, behavior: 'instant' });
                    hideLoading();

                    // Re-fire Alpine if needed
                    if (window.Alpine) {
                        window.Alpine.flushAndStopDeferringMutations();
                        window.Alpine.start();
                    }
                };

                if (cache.has(targetUrl)) {
                    loadPage(cache.get(targetUrl));
                } else {
                    fetch(targetUrl)
                        .then(res => res.text())
                        .then(html => {
                            cache.set(targetUrl, html);
                            loadPage(html);
                        })
                        .catch(() => {
                            window.location.href = targetUrl;
                        });
                }
            });

            window.addEventListener('popstate', function() {
                window.location.reload();
            });
        })();
    </script>
</body>
</html>
