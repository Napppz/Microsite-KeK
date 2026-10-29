<!-- COMPACT EVENT OVERVIEW: 4 Floating Glassmorphic Metric Cards -->
<section class="relative bg-[#060A10] border-b border-white/10 py-10 px-6 lg:px-12" id="overview">
    <div class="max-w-[1360px] mx-auto">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            <!-- Card 1: Tanggal -->
            <div class="glass-panel glass-panel-hover p-6 rounded-2xl border border-white/10 relative overflow-hidden group">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-[11px] font-bold uppercase tracking-widest text-amber-400">Tanggal Pelaksanaan</span>
                    <div class="w-8 h-8 rounded-lg bg-amber-500/10 border border-amber-500/20 flex items-center justify-center text-amber-400 group-hover:bg-amber-500/20 transition-colors">
                        <span class="material-symbols-outlined text-base">calendar_today</span>
                    </div>
                </div>
                <div class="font-serif text-xl sm:text-2xl text-white font-bold tracking-tight mb-1">{{ config('event.dates') }}</div>
                <div class="text-xs text-slate-400 font-medium">{{ config('event.time_schedule') }}</div>
            </div>

            <!-- Card 2: Lokasi -->
            <div class="glass-panel glass-panel-hover p-6 rounded-2xl border border-white/10 relative overflow-hidden group">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-[11px] font-bold uppercase tracking-widest text-blue-400">Tempat &amp; Lokasi</span>
                    <div class="w-8 h-8 rounded-lg bg-blue-500/10 border border-blue-500/20 flex items-center justify-center text-blue-400 group-hover:bg-blue-500/20 transition-colors">
                        <span class="material-symbols-outlined text-base">location_on</span>
                    </div>
                </div>
                <div class="font-serif text-xl sm:text-2xl text-white font-bold tracking-tight mb-1">{{ config('event.venue_name') }}</div>
                <div class="text-xs text-slate-400 font-medium">{{ config('event.venue_hint') }}</div>
            </div>

            <!-- Card 3: Penyelenggara -->
            <div class="glass-panel glass-panel-hover p-6 rounded-2xl border border-white/10 relative overflow-hidden group">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-[11px] font-bold uppercase tracking-widest text-emerald-400">Penyelenggara</span>
                    <div class="w-8 h-8 rounded-lg bg-emerald-500/10 border border-emerald-500/20 flex items-center justify-center text-emerald-400 group-hover:bg-emerald-500/20 transition-colors">
                        <span class="material-symbols-outlined text-base">verified</span>
                    </div>
                </div>
                <div class="font-serif text-xl sm:text-2xl text-white font-bold tracking-tight mb-1">{{ config('event.organizer') }}</div>
                <div class="text-xs text-slate-400 font-medium">{{ config('event.ministry') }}</div>
            </div>

            <!-- Card 4: Format -->
            <div class="glass-panel glass-panel-hover p-6 rounded-2xl border border-white/10 relative overflow-hidden group">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-[11px] font-bold uppercase tracking-widest text-purple-400">Format Partisipasi</span>
                    <div class="w-8 h-8 rounded-lg bg-purple-500/10 border border-purple-500/20 flex items-center justify-center text-purple-400 group-hover:bg-purple-500/20 transition-colors">
                        <span class="material-symbols-outlined text-base">handshake</span>
                    </div>
                </div>
                <div class="font-serif text-xl sm:text-2xl text-white font-bold tracking-tight mb-1">Pleno &amp; Matchmaking 1-on-1</div>
                <div class="text-xs text-slate-400 font-medium">Akreditasi Delegasi Terverifikasi</div>
            </div>
        </div>
    </div>
</section>
