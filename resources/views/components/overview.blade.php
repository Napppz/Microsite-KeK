<!-- EXECUTIVE SOVEREIGN OVERVIEW LEDGER -->
<section class="relative bg-[#070B12] border-b border-white/10 py-12 px-6 lg:px-12" id="overview">
    <div class="max-w-[1360px] mx-auto">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            
            <!-- Item 1: Tanggal Pelaksanaan -->
            <div class="pro-card pro-card-hover p-6 rounded-2xl border border-white/10 relative overflow-hidden group">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-[11px] font-bold uppercase tracking-widest text-amber-400 font-mono">Tanggal Pelaksanaan</span>
                    <span class="material-symbols-outlined text-base text-amber-400/80">calendar_today</span>
                </div>
                <div class="font-serif text-xl sm:text-2xl text-white font-bold tracking-tight mb-1">
                    {{ config('event.dates') }}
                </div>
                <div class="text-xs text-slate-400 font-mono">
                    {{ config('event.time_schedule') }}
                </div>
            </div>

            <!-- Item 2: Tempat & Lokasi -->
            <div class="pro-card pro-card-hover p-6 rounded-2xl border border-white/10 relative overflow-hidden group">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-[11px] font-bold uppercase tracking-widest text-sky-400 font-mono">Tempat &amp; Lokasi</span>
                    <span class="material-symbols-outlined text-base text-sky-400/80">location_on</span>
                </div>
                <div class="font-serif text-xl sm:text-2xl text-white font-bold tracking-tight mb-1">
                    {{ config('event.venue_name') }}
                </div>
                <div class="text-xs text-slate-400 font-mono">
                    {{ config('event.venue_hint') }}
                </div>
            </div>

            <!-- Item 3: Penyelenggara -->
            <div class="pro-card pro-card-hover p-6 rounded-2xl border border-white/10 relative overflow-hidden group">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-[11px] font-bold uppercase tracking-widest text-emerald-400 font-mono">Penyelenggara</span>
                    <span class="material-symbols-outlined text-base text-emerald-400/80">verified</span>
                </div>
                <div class="font-serif text-xl sm:text-2xl text-white font-bold tracking-tight mb-1">
                    {{ config('event.organizer') }}
                </div>
                <div class="text-xs text-slate-400">
                    {{ config('event.ministry') }}
                </div>
            </div>

            <!-- Item 4: Format Partisipasi -->
            <div class="pro-card pro-card-hover p-6 rounded-2xl border border-white/10 relative overflow-hidden group">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-[11px] font-bold uppercase tracking-widest text-purple-400 font-mono">Format Partisipasi</span>
                    <span class="material-symbols-outlined text-base text-purple-400/80">handshake</span>
                </div>
                <div class="font-serif text-xl sm:text-2xl text-white font-bold tracking-tight mb-1">
                    Pleno &amp; Matchmaking 1-on-1
                </div>
                <div class="text-xs text-slate-400">
                    Akreditasi Delegasi Terverifikasi
                </div>
            </div>

        </div>
    </div>
</section>
