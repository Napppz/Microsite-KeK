@extends('layouts.app')

@section('title', 'Dashboard Kehadiran & Laporan — ' . config('event.name'))

@section('content')
<div class="w-full bg-[#060A10] text-white py-8 sm:py-12 px-4 sm:px-6 lg:px-8 min-h-[90vh] relative overflow-hidden">
    <!-- Ambient Radial Lighting -->
    <div class="absolute top-10 left-1/3 -translate-x-1/2 w-[800px] h-[500px] bg-gradient-to-b from-[#D4AF37]/10 to-transparent rounded-full blur-[160px] pointer-events-none -z-10"></div>
    <div class="absolute bottom-20 right-10 w-[500px] h-[500px] bg-[#183B5B]/20 rounded-full blur-[140px] pointer-events-none -z-10"></div>

    <div class="max-w-[1360px] mx-auto space-y-6">

        <!-- Top Header & Event Context Bar -->
        <div class="glass-panel border border-white/15 p-5 sm:p-6 rounded-2xl flex flex-col md:flex-row items-center justify-between gap-4 shadow-xl">
            <div class="flex items-center gap-3.5">
                <img src="{{ asset('images/kek/logo-kek-white.png') }}" alt="Dewan Nasional KEK" class="h-8 sm:h-9 w-auto object-contain hidden sm:block">
                <div class="h-8 w-px bg-white/20 hidden sm:block"></div>
                <div>
                    <div class="text-[10px] uppercase tracking-[0.25em] text-[#D4AF37] font-semibold">
                        Sistem Rekapitulasi &amp; Laporan Protokoler
                    </div>
                    <h1 class="font-display text-xl sm:text-2xl font-bold text-white tracking-tight">
                        Dashboard Kehadiran {{ config('event.name') }} {{ $event->year }}
                    </h1>
                </div>
            </div>

            <!-- Actions & Identity -->
            <div class="flex items-center gap-2.5 self-end md:self-center flex-wrap justify-end">
                <a 
                    href="{{ route('staff.scanner') }}" 
                    class="px-4 py-2.5 rounded-xl gold-gradient-btn text-black text-xs font-bold uppercase tracking-wider flex items-center gap-2 transition-all shadow-lg hover:shadow-[#D4AF37]/25 cursor-pointer"
                >
                    <span class="material-symbols-outlined text-base">qr_code_scanner</span>
                    <span>Buka Pemindai QR</span>
                </a>

                <div class="text-right text-xs pl-3 border-l border-white/10 hidden sm:block">
                    <span class="font-semibold text-white block">{{ $staffUser->name }}</span>
                    <span class="text-[10px] text-slate-400 font-mono uppercase tracking-wider">{{ strtoupper($staffUser->role) }}</span>
                </div>

                <form method="POST" action="{{ route('staff.logout') }}">
                    @csrf
                    <button 
                        type="submit" 
                        title="Keluar dari sesi staf"
                        class="px-3.5 py-2.5 rounded-xl border border-white/15 hover:border-rose-400/50 hover:bg-rose-500/10 text-slate-300 hover:text-rose-300 text-xs flex items-center gap-1.5 transition-all cursor-pointer"
                    >
                        <span class="material-symbols-outlined text-base">logout</span>
                        <span class="hidden sm:inline">Keluar</span>
                    </button>
                </form>
            </div>
        </div>

        <!-- 4 Core Summary Metric Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
            
            <!-- Total Terdaftar -->
            <div class="glass-panel glass-panel-hover border border-white/10 p-6 rounded-2xl relative overflow-hidden transition-all duration-300">
                <div class="absolute top-0 left-0 right-0 h-1 bg-slate-500"></div>
                <div class="flex items-center justify-between text-slate-400 text-xs uppercase tracking-wider font-semibold mb-2">
                    <span>Total Delegasi</span>
                    <span class="material-symbols-outlined text-xl text-slate-500">groups</span>
                </div>
                <div class="font-mono text-3xl sm:text-4xl font-extrabold text-white tracking-tight" id="stat-total-registered">
                    {{ number_format($summary['total_registered']) }}
                </div>
                <div class="text-[11px] text-slate-400 mt-2 font-medium">
                    Delegasi sah dalam basis data acara
                </div>
            </div>

            <!-- Sudah Check-in -->
            <div class="glass-panel glass-panel-hover border border-white/10 p-6 rounded-2xl relative overflow-hidden transition-all duration-300">
                <div class="absolute top-0 left-0 right-0 h-1 bg-emerald-500"></div>
                <div class="flex items-center justify-between text-emerald-400/90 text-xs uppercase tracking-wider font-semibold mb-2">
                    <span>Sudah Check-in</span>
                    <span class="material-symbols-outlined text-xl text-emerald-400">how_to_reg</span>
                </div>
                <div class="font-mono text-3xl sm:text-4xl font-extrabold text-emerald-400 drop-shadow-[0_0_15px_rgba(52,211,153,0.3)] tracking-tight" id="stat-checked-in">
                    {{ number_format($summary['checked_in']) }}
                </div>
                <div class="text-[11px] text-emerald-400/80 mt-2 flex items-center gap-1.5 font-medium">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                    <span>Telah hadir di lokasi forum</span>
                </div>
            </div>

            <!-- Belum Check-in -->
            <div class="glass-panel glass-panel-hover border border-white/10 p-6 rounded-2xl relative overflow-hidden transition-all duration-300">
                <div class="absolute top-0 left-0 right-0 h-1 bg-[#D4AF37]"></div>
                <div class="flex items-center justify-between text-[#D4AF37] text-xs uppercase tracking-wider font-semibold mb-2">
                    <span>Belum Check-in</span>
                    <span class="material-symbols-outlined text-xl text-[#D4AF37]">pending_actions</span>
                </div>
                <div class="font-mono text-3xl sm:text-4xl font-extrabold text-[#F3E5AB] drop-shadow-[0_0_15px_rgba(212,175,55,0.25)] tracking-tight" id="stat-not-checked-in">
                    {{ number_format($summary['not_checked_in']) }}
                </div>
                <div class="text-[11px] text-slate-400 mt-2 font-medium">
                    Menunggu kedatangan di meja akreditasi
                </div>
            </div>

            <!-- Persentase Kehadiran -->
            <div class="glass-panel glass-panel-hover border border-white/10 p-6 rounded-2xl relative overflow-hidden transition-all duration-300">
                <div class="absolute top-0 left-0 right-0 h-1 bg-sky-500"></div>
                <div class="flex items-center justify-between text-sky-400 text-xs uppercase tracking-wider font-semibold mb-2">
                    <span>Tingkat Kehadiran</span>
                    <span class="material-symbols-outlined text-xl text-sky-400">pie_chart</span>
                </div>
                <div class="font-mono text-3xl sm:text-4xl font-extrabold text-sky-400 tracking-tight" id="stat-attendance-rate">
                    {{ $summary['attendance_rate'] }}%
                </div>
                <!-- Progress bar -->
                <div class="w-full h-2 bg-white/10 rounded-full mt-3 overflow-hidden">
                    <div class="h-full bg-gradient-to-r from-sky-500 to-emerald-400 rounded-full transition-all duration-500" style="width: {{ min(100, $summary['attendance_rate']) }}%"></div>
                </div>
            </div>

        </div>

        <!-- Analytical Breakdowns Grid (Category & Hourly Arrival) -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
            
            <!-- Category Breakdown (7 cols on lg) -->
            <div class="lg:col-span-7 glass-panel border border-white/15 p-6 rounded-2xl space-y-4">
                <div class="flex items-center justify-between pb-4 border-b border-white/10">
                    <div class="flex items-center gap-2.5">
                        <span class="material-symbols-outlined text-[#D4AF37] text-xl">category</span>
                        <h2 class="text-xs font-bold uppercase tracking-wider text-white">
                            Distribusi Kehadiran Berdasarkan Kategori Delegasi
                        </h2>
                    </div>
                    <span class="text-[11px] text-slate-400 font-mono">Real-time DB</span>
                </div>

                @if(count($categoryBreakdown) > 0)
                    <div class="space-y-4 pt-1">
                        @foreach($categoryBreakdown as $cat)
                            <div class="space-y-1.5">
                                <div class="flex items-center justify-between text-xs">
                                    <span class="font-semibold text-slate-200">{{ $cat['name'] }}</span>
                                    <span class="font-mono text-slate-300">
                                        <strong class="text-emerald-400 font-bold">{{ $cat['checked_in'] }}</strong> / {{ $cat['total'] }}
                                        <span class="text-slate-400 text-[10px]">({{ $cat['rate'] }}%)</span>
                                    </span>
                                </div>
                                <div class="w-full h-2.5 bg-white/10 rounded-full overflow-hidden flex">
                                    <div class="bg-gradient-to-r from-[#D4AF37] to-[#F3E5AB] h-full rounded-full transition-all duration-500" style="width: {{ min(100, $cat['rate']) }}%"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="py-8 text-center text-slate-500 text-xs">
                        Belum ada data kategori delegasi yang tercatat.
                    </div>
                @endif
            </div>

            <!-- Hourly Arrival Distribution (5 cols on lg) -->
            <div class="lg:col-span-5 glass-panel border border-white/15 p-6 rounded-2xl space-y-4">
                <div class="flex items-center justify-between pb-4 border-b border-white/10">
                    <div class="flex items-center gap-2.5">
                        <span class="material-symbols-outlined text-sky-400 text-xl">schedule</span>
                        <h2 class="text-xs font-bold uppercase tracking-wider text-white">
                            Pola Kedatangan per Jam (WIB)
                        </h2>
                    </div>
                    <span class="text-[11px] text-slate-400 font-mono">Waktu Lokal</span>
                </div>

                @if(count($hourlyArrivals) > 0)
                    <div class="space-y-3 pt-1">
                        @foreach($hourlyArrivals as $hour => $count)
                            <div class="flex items-center gap-3 text-xs">
                                <span class="w-14 font-mono text-slate-400 text-[11px]">{{ $hour }}</span>
                                <div class="flex-1 h-6 bg-white/[0.04] rounded-lg overflow-hidden flex items-center px-2.5 border border-white/5">
                                    <div class="bg-gradient-to-r from-sky-500 to-indigo-500 h-3 rounded-md transition-all duration-500" style="width: {{ min(100, $count * 20) }}%"></div>
                                    <span class="ml-2 font-mono text-[11px] font-bold text-white">{{ $count }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="py-8 text-center text-slate-500 text-xs">
                        Belum ada peserta yang melakukan check-in hari ini.
                    </div>
                @endif
            </div>

        </div>

        <!-- Filter Toolbar & Export Downloads -->
        <div class="glass-panel border border-white/15 p-6 rounded-2xl space-y-4">
            
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pb-4 border-b border-white/10">
                <div>
                    <h2 class="text-xs font-bold uppercase tracking-wider text-white flex items-center gap-2">
                        <span class="material-symbols-outlined text-[#D4AF37] text-lg">filter_list</span>
                        <span>Filter &amp; Pencarian Delegasi</span>
                    </h2>
                    <p class="text-xs text-slate-400 mt-1 font-normal">
                        Saring data daftar kehadiran peserta dan ekspor laporan resmi.
                    </p>
                </div>

                <!-- Export Action Buttons -->
                <div class="flex items-center gap-3">
                    <!-- CSV Export Button -->
                    <a 
                        href="{{ route('staff.reports.attendance.csv', request()->query()) }}" 
                        id="btn-export-csv"
                        class="px-4 py-2.5 rounded-xl bg-white/5 hover:bg-white/10 border border-white/15 hover:border-white/30 text-white text-xs font-semibold uppercase tracking-wider flex items-center gap-2 transition-all cursor-pointer"
                    >
                        <span class="material-symbols-outlined text-base text-[#D4AF37]">csv</span>
                        <span>Unduh CSV</span>
                    </a>

                    <!-- XLSX Export Button -->
                    <a 
                        href="{{ route('staff.reports.attendance.xlsx', request()->query()) }}" 
                        id="btn-export-xlsx"
                        class="px-4 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white text-xs font-bold uppercase tracking-wider flex items-center gap-2 transition-all cursor-pointer shadow-lg hover:shadow-emerald-600/30"
                    >
                        <span class="material-symbols-outlined text-base">table_view</span>
                        <span>Unduh Excel (.xlsx)</span>
                    </a>
                </div>
            </div>

            <!-- Filter Inputs Form -->
            <form method="GET" action="{{ route('staff.dashboard') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-12 gap-3.5 pt-1">
                
                <!-- Search Keyword (4 cols) -->
                <div class="lg:col-span-4">
                    <label for="search" class="block text-[10px] uppercase tracking-wider text-slate-400 font-semibold mb-1.5">
                        Pencarian Kata Kunci
                    </label>
                    <div class="relative">
                        <input 
                            type="text" 
                            name="search" 
                            id="search" 
                            value="{{ $filters['search'] ?? '' }}" 
                            placeholder="Cari nama, no. registrasi, instansi..."
                            class="w-full px-4 py-2.5 bg-white/[0.04] border border-white/15 focus:border-[#D4AF37] focus:ring-2 focus:ring-[#D4AF37]/20 rounded-xl text-xs text-white placeholder-slate-500 outline-none transition-all"
                        >
                        @if(!empty($filters['search']))
                            <a href="{{ route('staff.dashboard', array_diff_key(request()->query(), ['search' => ''])) }}" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-white text-sm">&times;</a>
                        @endif
                    </div>
                </div>

                <!-- Status Kehadiran (3 cols) -->
                <div class="lg:col-span-3">
                    <label for="attendance_status" class="block text-[10px] uppercase tracking-wider text-slate-400 font-semibold mb-1.5">
                        Status Kehadiran
                    </label>
                    <select 
                        name="attendance_status" 
                        id="attendance_status" 
                        class="w-full px-4 py-2.5 bg-[#060A10] border border-white/15 focus:border-[#D4AF37] rounded-xl text-xs text-white outline-none cursor-pointer transition-all"
                    >
                        <option value="all" {{ ($filters['attendance_status'] ?? '') === 'all' ? 'selected' : '' }}>Semua Kehadiran</option>
                        <option value="checked_in" {{ ($filters['attendance_status'] ?? '') === 'checked_in' ? 'selected' : '' }}>Sudah Check-in (Hadir)</option>
                        <option value="not_checked_in" {{ ($filters['attendance_status'] ?? '') === 'not_checked_in' ? 'selected' : '' }}>Belum Check-in</option>
                    </select>
                </div>

                <!-- Kategori Partisipasi (3 cols) -->
                <div class="lg:col-span-3">
                    <label for="category" class="block text-[10px] uppercase tracking-wider text-slate-400 font-semibold mb-1.5">
                        Kategori Partisipasi
                    </label>
                    <select 
                        name="category" 
                        id="category" 
                        class="w-full px-4 py-2.5 bg-[#060A10] border border-white/15 focus:border-[#D4AF37] rounded-xl text-xs text-white outline-none cursor-pointer transition-all"
                    >
                        <option value="all">Semua Kategori</option>
                        @foreach($availableCategories as $catVal)
                            <option value="{{ $catVal }}" {{ ($filters['category'] ?? '') === $catVal ? 'selected' : '' }}>
                                {{ ucwords(str_replace('_', ' ', $catVal)) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Submit & Reset Buttons (2 cols) -->
                <div class="lg:col-span-2 flex items-end gap-2">
                    <button 
                        type="submit" 
                        id="btn-apply-filter"
                        class="flex-1 py-2.5 bg-white/10 hover:bg-white/20 border border-white/20 hover:border-white/40 text-white text-xs font-bold uppercase tracking-wider rounded-xl transition-all cursor-pointer"
                    >
                        Filter
                    </button>
                    @if(count(array_filter($filters)) > 0)
                        <a 
                            href="{{ route('staff.dashboard') }}" 
                            title="Reset semua filter"
                            class="px-3 py-2.5 border border-white/15 hover:border-white text-slate-400 hover:text-white rounded-xl text-xs flex items-center justify-center transition-all"
                        >
                            <span class="material-symbols-outlined text-base">restart_alt</span>
                        </a>
                    @endif
                </div>

            </form>
        </div>

        <!-- Participants Attendance Table Card -->
        <div class="glass-panel border border-white/15 rounded-2xl overflow-hidden shadow-2xl space-y-4">
            
            <div class="p-5 sm:p-6 flex items-center justify-between border-b border-white/10">
                <div class="text-xs font-bold uppercase tracking-wider text-white flex items-center gap-2">
                    <span class="material-symbols-outlined text-[#D4AF37] text-lg">table_rows</span>
                    <span>Daftar Delegasi &amp; Status Kehadiran</span>
                </div>
                <div class="text-xs text-slate-400 font-medium">
                    Menampilkan {{ $participants->firstItem() ?? 0 }}–{{ $participants->lastItem() ?? 0 }} dari {{ $participants->total() }} delegasi
                </div>
            </div>

            <!-- Table Container with Horizontal Scroll -->
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs" id="participants-table">
                    <thead>
                        <tr class="border-b border-white/10 bg-white/[0.02] text-slate-400 text-[10px] uppercase tracking-wider">
                            <th class="py-3.5 px-5 font-semibold">No. Registrasi</th>
                            <th class="py-3.5 px-5 font-semibold">Nama Delegasi</th>
                            <th class="py-3.5 px-5 font-semibold">Instansi / Perusahaan</th>
                            <th class="py-3.5 px-5 font-semibold">Kategori</th>
                            <th class="py-3.5 px-5 font-semibold">Status Kehadiran</th>
                            <th class="py-3.5 px-5 font-semibold">Waktu Check-in</th>
                            <th class="py-3.5 px-5 font-semibold">Pintu &amp; Petugas</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5 text-slate-300">
                        @forelse($participants as $participant)
                            @php
                                $hasCheckedIn = $participant->checkIn !== null;
                            @endphp
                            <tr class="hover:bg-white/[0.03] transition-colors">
                                <!-- Registration Code -->
                                <td class="py-3.5 px-5 font-mono font-bold text-[#F3E5AB] whitespace-nowrap">
                                    {{ $participant->registration_code }}
                                </td>

                                <!-- Delegate Name & Position -->
                                <td class="py-3.5 px-5">
                                    <div class="font-bold text-white text-sm">{{ $participant->full_name }}</div>
                                    <div class="text-[11px] text-slate-400 font-medium">{{ $participant->position }}</div>
                                </td>

                                <!-- Company -->
                                <td class="py-3.5 px-5 text-slate-200 font-medium">
                                    {{ $participant->company_name }}
                                </td>

                                <!-- Category Badge -->
                                <td class="py-3.5 px-5 whitespace-nowrap">
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-semibold uppercase tracking-wider bg-white/5 border border-white/10 text-slate-200">
                                        {{ $participant->participation_category }}
                                    </span>
                                </td>

                                <!-- Attendance Status Badge -->
                                <td class="py-3.5 px-5 whitespace-nowrap">
                                    @if($hasCheckedIn)
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-500/15 text-emerald-300 border border-emerald-500/30 text-xs font-semibold">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                                            <span>Hadir</span>
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/5 text-slate-400 border border-white/10 text-xs font-medium">
                                            <span class="w-1.5 h-1.5 rounded-full bg-slate-500"></span>
                                            <span>Belum Hadir</span>
                                        </span>
                                    @endif
                                </td>

                                <!-- Check-in Timestamp -->
                                <td class="py-3.5 px-5 font-mono text-xs whitespace-nowrap">
                                    @if($hasCheckedIn)
                                        <span class="text-emerald-400 font-semibold">
                                            {{ $participant->checkIn->checked_in_at->setTimezone('Asia/Jakarta')->format('d M, H:i') }} WIB
                                        </span>
                                    @else
                                        <span class="text-slate-600">-</span>
                                    @endif
                                </td>

                                <!-- Gate and Staff -->
                                <td class="py-3.5 px-5 text-xs whitespace-nowrap">
                                    @if($hasCheckedIn)
                                        <div class="text-slate-200 font-medium">{{ $participant->checkIn->gate_or_hall ?: 'Pintu Utama' }}</div>
                                        <div class="text-slate-400 text-[10px]">{{ $participant->checkIn->user?->name ?: 'Petugas Staf' }}</div>
                                    @else
                                        <span class="text-slate-600">-</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-12 text-center text-slate-500">
                                    <div class="space-y-2">
                                        <span class="material-symbols-outlined text-4xl block text-slate-600">search_off</span>
                                        <p class="text-xs">Tidak ditemukan delegasi yang cocok dengan kriteria pencarian atau filter.</p>
                                        @if(count(array_filter($filters)) > 0)
                                            <a href="{{ route('staff.dashboard') }}" class="text-xs text-[#D4AF37] hover:underline inline-block mt-1 font-semibold">
                                                Reset Filter Pencarian
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination Links -->
            @if($participants->hasPages())
                <div class="p-5 border-t border-white/10 flex flex-col sm:flex-row items-center justify-between gap-4">
                    <div class="text-xs text-slate-400">
                        Halaman {{ $participants->currentPage() }} dari {{ $participants->lastPage() }}
                    </div>
                    <div>
                        {{ $participants->withQueryString()->links() }}
                    </div>
                </div>
            @endif

        </div>

    </div>
</div>
@endsection
