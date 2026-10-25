<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-xl text-gray-800 leading-tight">
                Audit Trail & Activity Log Sistem
            </h2>
            <span class="text-xs bg-amber-100 text-amber-800 px-3 py-1 rounded-full font-bold">Admin Audit Only</span>
        </div>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-4">
        <!-- Search & Filter Bar -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
            <form method="GET" action="{{ route('activity_logs.index') }}" class="grid grid-cols-1 md:grid-cols-3 gap-3">
                <div>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama user, aksi, deskripsi..." class="w-full rounded-lg border-gray-300 text-sm focus:border-pink-400 focus:ring-pink-300">
                </div>
                <div>
                    <select name="action" class="w-full rounded-lg border-gray-300 text-sm focus:border-pink-400 focus:ring-pink-300">
                        <option value="">-- Semua Aksi --</option>
                        @foreach($actions as $action)
                            <option value="{{ $action }}" {{ request('action') == $action ? 'selected' : '' }}>{{ $action }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex items-center space-x-2">
                    <button type="submit" class="w-full bg-pink-500 hover:bg-pink-600 text-white font-bold text-sm py-2 rounded-lg shadow-sm shadow-pink-200 transition">Filter</button>
                    @if(request('search') || request('action'))
                        <a href="{{ route('activity_logs.index') }}" class="px-3 py-2 border border-gray-300 rounded-lg text-xs font-semibold text-gray-600 hover:bg-gray-50">Reset</a>
                    @endif
                </div>
            </form>
            <p class="mt-3 pt-3 border-t border-gray-100 text-xs text-gray-500">Total Log Aktivitas: <strong>{{ number_format($activities->total(), 0, ',', '.') }}</strong></p>
        </div>

        <!-- Table -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
            <table class="w-full min-w-[760px] text-left text-sm text-gray-600">
                <thead class="bg-gray-50 text-gray-700 uppercase text-xs border-b border-gray-100">
                    <tr>
                        <th class="px-6 py-4">No</th>
                        <th class="px-6 py-4">Waktu</th>
                        <th class="px-6 py-4">Pengguna (User)</th>
                        <th class="px-6 py-4">Aksi (Action)</th>
                        <th class="px-6 py-4">Deskripsi Rinci</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($activities as $index => $act)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 font-mono text-xs text-gray-400">
                                {{ $activities->firstItem() + $index }}
                            </td>
                            <td class="px-6 py-4 text-xs text-gray-500 whitespace-nowrap font-medium">
                                {{ $act->created_at->translatedFormat('d M Y, H:i:s') }}
                            </td>
                            <td class="px-6 py-4 font-bold text-gray-900">
                                {{ $act->user->name ?? 'System' }}
                                <span class="block text-xs font-normal text-gray-400">({{ strtoupper($act->user->role ?? '-') }})</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2.5 py-1 text-xs font-mono font-bold rounded bg-gray-100 text-gray-800 border border-gray-200">
                                    {{ $act->action }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-gray-700">
                                {{ $act->description }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                                Belum ada log aktivitas tercatat di sistem.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            </div>
            <div class="p-4 border-t border-gray-100">
                {{ $activities->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
