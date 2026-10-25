<header class="sticky top-0 z-40 bg-white/90 backdrop-blur-xl border-b border-slate-200/80 transition-all" x-data="{ open: false }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16 sm:h-[70px] gap-2 sm:gap-4">
            <!-- Left: Logo & Identity -->
            <div class="flex items-center gap-2.5 sm:gap-3.5 shrink-0">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-2 sm:gap-3.5">
                    <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl bg-slate-900 text-white flex items-center justify-center shadow-subtle border border-slate-800 shrink-0">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 text-indigo-400" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path>
                            <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
                            <line x1="12" x2="12" y1="22.08" y2="12"></line>
                        </svg>
                    </div>
                    <div>
                        <div class="flex items-center gap-1.5 sm:gap-2">
                            <span class="text-xs sm:text-sm font-bold tracking-wider text-slate-900 uppercase">INVENTARIS SEKOLAH</span>
                            <span class="hidden sm:inline-flex items-center px-1.5 py-0.5 rounded-full text-[10px] font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200/80">
                                <span class="w-1 h-1 rounded-full bg-emerald-500 mr-1 animate-pulse"></span> v2.4 Live
                            </span>
                        </div>
                        <p class="text-[10px] sm:text-[11px] text-slate-500 font-medium">SMKN 1 KETAPANG</p>
                    </div>
                </a>
            </div>

            <!-- Middle: Nav Links (Desktop Modern Pill Tabs) -->
            <nav aria-label="Main Navigation" class="hidden md:flex items-center p-1 bg-slate-100/90 rounded-xl border border-slate-200/70">
                <a class="px-3 py-1.5 rounded-lg text-xs font-semibold {{ request()->routeIs('dashboard') ? 'bg-white text-slate-900 shadow-sm border border-slate-200/50' : 'text-slate-600 hover:text-slate-900 hover:bg-white/50' }} flex items-center gap-1.5 transition-all" href="{{ route('dashboard') }}">
                    <svg class="w-3.5 h-3.5 {{ request()->routeIs('dashboard') ? 'text-indigo-600' : 'text-slate-400' }}" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                        <rect height="7" rx="1.5" width="7" x="3" y="3"></rect>
                        <rect height="7" rx="1.5" width="7" x="14" y="3"></rect>
                        <rect height="7" rx="1.5" width="7" x="14" y="14"></rect>
                        <rect height="7" rx="1.5" width="7" x="3" y="14"></rect>
                    </svg>
                    <span>Dashboard</span>
                </a>

                <a class="px-3 py-1.5 rounded-lg text-xs font-semibold {{ request()->routeIs('items.*') ? 'bg-white text-slate-900 shadow-sm border border-slate-200/50' : 'text-slate-600 hover:text-slate-900 hover:bg-white/50' }} flex items-center gap-1.5 transition-all" href="{{ route('items.index') }}">
                    <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path>
                        <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path>
                    </svg>
                    <span>Katalog Barang</span>
                </a>

                <a class="px-3 py-1.5 rounded-lg text-xs font-semibold {{ request()->routeIs('loans.*') ? 'bg-white text-slate-900 shadow-sm border border-slate-200/50' : 'text-slate-600 hover:text-slate-900 hover:bg-white/50' }} flex items-center gap-1.5 transition-all" href="{{ route('loans.index') }}">
                    <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="10"></circle>
                        <polyline points="12 6 12 12 16 14"></polyline>
                    </svg>
                    <span>Peminjaman</span>
                </a>

                @if(Auth::user()->isAdmin())
                    <a class="px-3 py-1.5 rounded-lg text-xs font-semibold {{ request()->routeIs('categories.*') ? 'bg-white text-slate-900 shadow-sm border border-slate-200/50' : 'text-slate-600 hover:text-slate-900 hover:bg-white/50' }} transition-all" href="{{ route('categories.index') }}">
                        Kategori
                    </a>
                    <a class="px-3 py-1.5 rounded-lg text-xs font-semibold {{ request()->routeIs('returns.*') ? 'bg-white text-slate-900 shadow-sm border border-slate-200/50' : 'text-slate-600 hover:text-slate-900 hover:bg-white/50' }} transition-all" href="{{ route('returns.index') }}">
                        Pengembalian
                    </a>
                    <a class="px-3 py-1.5 rounded-lg text-xs font-semibold {{ request()->routeIs('users.*') ? 'bg-white text-slate-900 shadow-sm border border-slate-200/50' : 'text-slate-600 hover:text-slate-900 hover:bg-white/50' }} transition-all" href="{{ route('users.index') }}">
                        User
                    </a>
                    <a class="px-3 py-1.5 rounded-lg text-xs font-semibold {{ request()->routeIs('activity_logs.*') ? 'bg-white text-slate-900 shadow-sm border border-slate-200/50' : 'text-slate-600 hover:text-slate-900 hover:bg-white/50' }} transition-all" href="{{ route('activity_logs.index') }}">
                        Activity Log
                    </a>
                @endif
            </nav>

            <!-- Right: Actions, User Monogram, & Hamburger -->
            <div class="flex items-center gap-1.5 sm:gap-2.5 shrink-0">
                <!-- Primary CTA -->
                <a href="{{ route('loans.create') }}" class="btn-shine inline-flex items-center gap-1 sm:gap-2 px-2.5 sm:px-3.5 py-1.5 sm:py-2 rounded-xl bg-slate-900 hover:bg-slate-800 text-white text-xs font-semibold shadow-sm hover:shadow transition-all active:scale-[0.98]">
                    <svg class="w-3.5 h-3.5 text-indigo-400" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <line x1="12" x2="12" y1="5" y2="19"></line>
                        <line x1="5" x2="19" y1="12" y2="12"></line>
                    </svg>
                    <span class="hidden sm:inline">Ajukan Pinjaman</span>
                    <span class="sm:hidden text-[11px]">+ Pinjam</span>
                </a>

                <div class="h-5 w-px bg-slate-200 hidden sm:block"></div>

                <!-- User Monogram Card Dropdown -->
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <div class="flex items-center gap-1.5 sm:gap-2.5 p-1 sm:pl-1.5 sm:pr-2.5 sm:py-1 rounded-xl bg-white border border-slate-200/90 shadow-subtle hover:border-slate-300 transition-all cursor-pointer">
                            <div class="w-7 h-7 rounded-lg bg-gradient-to-tr from-indigo-600 to-indigo-500 text-white font-bold text-xs flex items-center justify-center shadow-xs shrink-0">
                                {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                            </div>
                            <div class="hidden sm:block text-left leading-tight">
                                <div class="text-xs font-bold text-slate-900">{{ Auth::user()->name }}</div>
                                <div class="text-[10px] text-slate-500 font-medium capitalize">{{ Auth::user()->role }} &bull; {{ Auth::user()->isAdmin() ? 'Pengelola' : 'Siswa/Guru' }}</div>
                            </div>
                            <svg class="w-3.5 h-3.5 text-slate-400 hidden sm:block ml-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <polyline points="6 9 12 15 18 9"></polyline>
                            </svg>
                        </div>
                    </x-slot>

                    <x-slot name="content">
                        <div class="px-4 py-2 border-b border-slate-100 sm:hidden">
                            <div class="font-bold text-xs text-slate-900">{{ Auth::user()->name }}</div>
                            <div class="text-[10px] text-slate-500 capitalize">{{ Auth::user()->email }}</div>
                        </div>
                        <x-dropdown-link :href="route('profile.edit')">
                            Profile Akun
                        </x-dropdown-link>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                                Keluar (Logout)
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>

                <!-- Hamburger Button for Mobile -->
                <button @click="open = ! open" type="button" class="md:hidden inline-flex items-center justify-center p-2 rounded-xl text-slate-600 hover:text-slate-900 hover:bg-slate-100 focus:outline-none transition-colors border border-slate-200/80">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>


    <!-- Responsive Mobile Menu Navigation Drawer -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden md:hidden border-t border-slate-200/80 bg-white/95 backdrop-blur-xl px-4 pt-3 pb-5 space-y-1.5 shadow-float">
        <a class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold {{ request()->routeIs('dashboard') ? 'bg-indigo-50 text-indigo-700 font-bold' : 'text-slate-700 hover:bg-slate-50' }}" href="{{ route('dashboard') }}">
            <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect height="7" rx="1.5" width="7" x="3" y="3"></rect><rect height="7" rx="1.5" width="7" x="14" y="3"></rect><rect height="7" rx="1.5" width="7" x="14" y="14"></rect><rect height="7" rx="1.5" width="7" x="3" y="14"></rect></svg>
            Dashboard
        </a>
        <a class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold {{ request()->routeIs('items.*') ? 'bg-indigo-50 text-indigo-700 font-bold' : 'text-slate-700 hover:bg-slate-50' }}" href="{{ route('items.index') }}">
            <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path></svg>
            Katalog Barang
        </a>
        <a class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold {{ request()->routeIs('loans.*') ? 'bg-indigo-50 text-indigo-700 font-bold' : 'text-slate-700 hover:bg-slate-50' }}" href="{{ route('loans.index') }}">
            <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
            Peminjaman
        </a>

        @if(Auth::user()->isAdmin())
            <div class="pt-2 pb-1 border-t border-slate-100 my-1">
                <span class="px-3 text-[10px] font-bold uppercase tracking-wider text-slate-400">Menu Pengelola (Admin)</span>
            </div>
            <a class="flex items-center gap-3 px-3 py-2 rounded-xl text-xs font-semibold {{ request()->routeIs('categories.*') ? 'bg-indigo-50 text-indigo-700' : 'text-slate-700 hover:bg-slate-50' }}" href="{{ route('categories.index') }}">
                <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4 6h16M4 12h16M4 18h16"></path></svg>
                <span>Kategori Barang</span>
            </a>
            <a class="flex items-center gap-3 px-3 py-2 rounded-xl text-xs font-semibold {{ request()->routeIs('returns.*') ? 'bg-indigo-50 text-indigo-700' : 'text-slate-700 hover:bg-slate-50' }}" href="{{ route('returns.index') }}">
                <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                <span>Pengembalian Barang</span>
            </a>
            <a class="flex items-center gap-3 px-3 py-2 rounded-xl text-xs font-semibold {{ request()->routeIs('users.*') ? 'bg-indigo-50 text-indigo-700' : 'text-slate-700 hover:bg-slate-50' }}" href="{{ route('users.index') }}">
                <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle></svg>
                <span>Manajemen User</span>
            </a>
            <a class="flex items-center gap-3 px-3 py-2 rounded-xl text-xs font-semibold {{ request()->routeIs('activity_logs.*') ? 'bg-indigo-50 text-indigo-700' : 'text-slate-700 hover:bg-slate-50' }}" href="{{ route('activity_logs.index') }}">
                <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                <span>Activity Log (Audit Trail)</span>
            </a>
        @endif

        <div class="pt-2 border-t border-slate-100 my-1">
            <a class="flex items-center gap-3 px-3 py-2 rounded-xl text-xs font-semibold text-slate-700 hover:bg-slate-50" href="{{ route('profile.edit') }}">
                <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                <span>Profile Akun</span>
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full text-left flex items-center gap-3 px-3 py-2 rounded-xl text-xs font-semibold text-rose-600 hover:bg-rose-50">
                    <svg class="w-4 h-4 text-rose-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" x2="9" y1="12" y2="12"></line></svg>
                    <span>Keluar (Logout)</span>
                </button>
            </form>
        </div>
    </div>
</header>

<!-- FIXED BOTTOM MOBILE NAVIGATION BAR WITH COMPLETE SLIDE-UP SHEET -->
<div x-data="{ menuOpen: false }">
    <nav class="md:hidden fixed bottom-0 left-0 right-0 z-50 bg-white/95 backdrop-blur-xl border-t border-slate-200/90 shadow-float px-2 py-2 flex items-center justify-around select-none">
        <!-- Dashboard / Home -->
        <a href="{{ route('dashboard') }}" class="flex flex-col items-center justify-center py-1 px-3.5 rounded-xl transition-all duration-150 active:scale-90 {{ request()->routeIs('dashboard') ? 'bg-indigo-50 text-indigo-700 font-bold border border-indigo-100/80 shadow-xs' : 'text-slate-500 hover:text-slate-800' }}">
            <svg class="w-5 h-5 {{ request()->routeIs('dashboard') ? 'text-indigo-600' : 'text-slate-400' }}" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                <rect height="7" rx="1.5" width="7" x="3" y="3"></rect>
                <rect height="7" rx="1.5" width="7" x="14" y="3"></rect>
                <rect height="7" rx="1.5" width="7" x="14" y="14"></rect>
                <rect height="7" rx="1.5" width="7" x="3" y="14"></rect>
            </svg>
            <span class="text-[10px] mt-0.5 font-semibold tracking-tight">Home</span>
        </a>

        <!-- Katalog Barang -->
        <a href="{{ route('items.index') }}" class="flex flex-col items-center justify-center py-1 px-3.5 rounded-xl transition-all duration-150 active:scale-90 {{ request()->routeIs('items.*') ? 'bg-indigo-50 text-indigo-700 font-bold border border-indigo-100/80 shadow-xs' : 'text-slate-500 hover:text-slate-800' }}">
            <svg class="w-5 h-5 {{ request()->routeIs('items.*') ? 'text-indigo-600' : 'text-slate-400' }}" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path>
                <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path>
            </svg>
            <span class="text-[10px] mt-0.5 font-semibold tracking-tight">Barang</span>
        </a>

        <!-- Pinjam CTA (Center Floating Action Button) -->
        <a href="{{ route('loans.create') }}" class="flex flex-col items-center justify-center -mt-5 group active:scale-90 transition-transform">
            <div class="w-12 h-12 rounded-full bg-indigo-600 hover:bg-indigo-700 text-white flex items-center justify-center shadow-lg shadow-indigo-500/30 border-2 border-white transition-all">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <line x1="12" x2="12" y1="5" y2="19"></line>
                    <line x1="5" x2="19" y1="12" y2="12"></line>
                </svg>
            </div>
            <span class="text-[10px] text-indigo-600 font-bold mt-0.5">Pinjam</span>
        </a>

        <!-- Peminjaman -->
        <a href="{{ route('loans.index') }}" class="flex flex-col items-center justify-center py-1 px-3.5 rounded-xl transition-all duration-150 active:scale-90 {{ request()->routeIs('loans.*') ? 'bg-indigo-50 text-indigo-700 font-bold border border-indigo-100/80 shadow-xs' : 'text-slate-500 hover:text-slate-800' }}">
            <svg class="w-5 h-5 {{ request()->routeIs('loans.*') ? 'text-indigo-600' : 'text-slate-400' }}" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                <circle cx="12" cy="12" r="10"></circle>
                <polyline points="12 6 12 12 16 14"></polyline>
            </svg>
            <span class="text-[10px] mt-0.5 font-semibold tracking-tight">Pinjaman</span>
        </a>

        <!-- Menu / Lainnya Drawer Trigger -->
        <button type="button" @click="menuOpen = !menuOpen" class="flex flex-col items-center justify-center py-1 px-3.5 rounded-xl transition-all duration-150 active:scale-90 {{ (request()->routeIs('categories.*') || request()->routeIs('returns.*') || request()->routeIs('users.*') || request()->routeIs('activity_logs.*') || request()->routeIs('profile.*')) ? 'bg-indigo-50 text-indigo-700 font-bold border border-indigo-100/80 shadow-xs' : 'text-slate-500 hover:text-slate-800' }}">
            <svg class="w-5 h-5 {{ (request()->routeIs('categories.*') || request()->routeIs('returns.*') || request()->routeIs('users.*') || request()->routeIs('activity_logs.*') || request()->routeIs('profile.*')) ? 'text-indigo-600' : 'text-slate-400' }}" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                <circle cx="12" cy="5" r="1.5"></circle>
                <circle cx="12" cy="12" r="1.5"></circle>
                <circle cx="12" cy="19" r="1.5"></circle>
            </svg>
            <span class="text-[10px] mt-0.5 font-semibold tracking-tight">Menu</span>
        </button>
    </nav>

    <!-- Slide-Up Bottom Sheet Modal for Mobile Menu -->
    <div x-show="menuOpen" @click.self="menuOpen = false" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="md:hidden fixed inset-0 z-50 bg-slate-900/40 backdrop-blur-xs flex items-end justify-center" style="display: none;">
        <div x-show="menuOpen" x-transition:enter="transition ease-out duration-250 transform" x-transition:enter-start="translate-y-full" x-transition:enter-end="translate-y-0" x-transition:leave="transition ease-in duration-200 transform" x-transition:leave-start="translate-y-0" x-transition:leave-end="translate-y-full" class="w-full bg-white rounded-t-3xl p-5 shadow-float max-h-[85vh] overflow-y-auto space-y-4">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                <div class="flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-indigo-600"></span>
                    <h3 class="text-sm font-bold text-slate-900">Menu Navigasi Lengkap</h3>
                </div>
                <button type="button" @click="menuOpen = false" class="text-slate-400 hover:text-slate-600 p-1">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="18" x2="6" y1="6" y2="18"></line><line x1="6" x2="18" y1="6" y2="18"></line></svg>
                </button>
            </div>

            @if(Auth::user()->isAdmin())
                <div class="space-y-1">
                    <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400 px-3 pb-1">Pengelola (Admin)</p>
                    
                    <a href="{{ route('categories.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold {{ request()->routeIs('categories.*') ? 'bg-indigo-50 text-indigo-700' : 'text-slate-700 hover:bg-slate-50' }}">
                        <div class="w-8 h-8 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4 6h16M4 12h16M4 18h16"></path></svg>
                        </div>
                        <div>
                            <div class="font-bold text-slate-900">Kategori Barang</div>
                            <div class="text-[10px] text-slate-500">Kelola kategori inventaris</div>
                        </div>
                    </a>

                    <a href="{{ route('returns.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold {{ request()->routeIs('returns.*') ? 'bg-indigo-50 text-indigo-700' : 'text-slate-700 hover:bg-slate-50' }}">
                        <div class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                        </div>
                        <div>
                            <div class="font-bold text-slate-900">Pengembalian Barang</div>
                            <div class="text-[10px] text-slate-500">Catat kondisi & catatan barang</div>
                        </div>
                    </a>

                    <a href="{{ route('users.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold {{ request()->routeIs('users.*') ? 'bg-indigo-50 text-indigo-700' : 'text-slate-700 hover:bg-slate-50' }}">
                        <div class="w-8 h-8 rounded-lg bg-sky-50 text-sky-600 flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle></svg>
                        </div>
                        <div>
                            <div class="font-bold text-slate-900">Manajemen User (Pengguna)</div>
                            <div class="text-[10px] text-slate-500">Kelola akun Admin, Guru, & Siswa</div>
                        </div>
                    </a>

                    <a href="{{ route('activity_logs.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold {{ request()->routeIs('activity_logs.*') ? 'bg-indigo-50 text-indigo-700' : 'text-slate-700 hover:bg-slate-50' }}">
                        <div class="w-8 h-8 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                        </div>
                        <div>
                            <div class="font-bold text-slate-900">Activity Log (Audit Trail)</div>
                            <div class="text-[10px] text-slate-500">Riwayat log sistem & transaksi</div>
                        </div>
                    </a>
                </div>
            @endif

            <div class="pt-2 border-t border-slate-100 space-y-1">
                <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400 px-3 pb-1">Pengaturan Akun</p>
                <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold text-slate-700 hover:bg-slate-50">
                    <div class="w-8 h-8 rounded-lg bg-slate-100 text-slate-600 flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                    </div>
                    <div>
                        <div class="font-bold text-slate-900">Profil Akun</div>
                        <div class="text-[10px] text-slate-500">{{ Auth::user()->email }}</div>
                    </div>
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-left flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold text-rose-600 hover:bg-rose-50">
                        <div class="w-8 h-8 rounded-lg bg-rose-50 text-rose-600 flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" x2="9" y1="12" y2="12"></line></svg>
                        </div>
                        <div>
                            <div class="font-bold text-rose-600">Keluar (Logout)</div>
                            <div class="text-[10px] text-rose-400">Akhiri sesi akun Anda</div>
                        </div>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
