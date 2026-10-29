<!-- HERO SECTION: Mastercrafted Sovereign Summit Editorial Hero -->
<section class="relative bg-[#060A10] bg-dot-matrix text-white pt-16 pb-24 px-6 lg:px-12 border-b border-white/10 overflow-hidden" id="hero">
    <!-- Subtle Ambient Depth Glows -->
    <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[900px] h-[360px] bg-gradient-to-b from-[#1E3A8A]/12 via-[#F59E0B]/08 to-transparent rounded-full blur-[140px] pointer-events-none -z-10"></div>

    <div class="max-w-[1360px] mx-auto">
        <!-- Institutional Kicker -->
        <div class="flex items-center gap-2 mb-6">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/[0.04] border border-white/10 text-[11px] font-mono tracking-wider text-slate-300 uppercase">
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                <span>Sekretariat Jenderal Dewan Nasional KEK</span>
            </span>
            <span class="text-white/20 text-xs hidden sm:inline">&bull;</span>
            <span class="text-xs text-slate-400 font-mono tracking-wider uppercase hidden sm:inline">Penyelenggaraan Resmi Edisi {{ config('event.year') }}</span>
        </div>

        <!-- Monumental Editorial Headline & Value Prop -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-end pb-16">
            <div class="lg:col-span-8">
                <h1 class="font-serif text-4xl sm:text-6xl lg:text-[68px] leading-[1.08] font-extrabold tracking-tight text-white">
                    <span class="gold-gradient-text">Akselerasi Investasi Strategis &amp; Masa Depan Industri Kawasan</span>
                </h1>
            </div>
            <div class="lg:col-span-4 flex flex-col gap-6 lg:pl-6 lg:border-l lg:border-white/10">
                <p class="text-sm sm:text-base text-slate-300 font-normal leading-relaxed">
                    Forum Tingkat Tinggi Tahunan Dewan Nasional Kawasan Ekonomi Khusus yang mempertemukan pimpinan kabinet, otoritas pengelola 22 Kawasan Ekonomi Khusus, serta jajaran investor multinasional untuk memantapkan komitmen investasi riil, kepastian regulasi, dan hilirisasi strategis nasional.
                </p>
                <div class="flex flex-wrap items-center gap-4 pt-1">
                    <a 
                        id="hero-cta-register"
                        class="inline-flex items-center gap-2.5 px-7 py-3.5 rounded-full gold-gradient-btn text-xs font-bold uppercase tracking-wider transition-all duration-200 cursor-pointer"
                        href="{{ Route::has('registration.index') ? route('registration.index') : '#registrasi' }}"
                    >
                        <span>Daftar Delegasi</span>
                        <span class="material-symbols-outlined text-base">arrow_forward</span>
                    </a>
                    <a 
                        id="hero-cta-agenda"
                        class="inline-flex items-center gap-2 px-6 py-3.5 rounded-full bg-white/[0.04] hover:bg-white/[0.08] text-white text-xs font-semibold uppercase tracking-wider transition-all duration-200 border border-white/15 hover:border-white/30"
                        href="#agenda"
                    >
                        <span>Lihat Jadwal Pleno</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Cinematic Summit Showcase Frame -->
        <div class="relative w-full overflow-hidden rounded-2xl border border-white/15 shadow-[0_25px_60px_-15px_rgba(0,0,0,0.8)] pro-card group">
            <div class="relative aspect-[16/9] lg:aspect-[23/10] w-full bg-[#0d1624] overflow-hidden">
                <img 
                    id="hero-summit-image"
                    alt="Sidang Pleno KEK Business Forum {{ config('event.year') }}" 
                    class="w-full h-full object-cover filter brightness-95 contrast-105 group-hover:scale-102 transition-transform duration-700 ease-out" 
                    src="{{ asset('images/kek/hero-plenary.jpg') }}"
                    loading="eager"
                />
                <!-- Subtle vignette and gradient overlays -->
                <div class="absolute inset-0 bg-gradient-to-t from-[#060A10] via-transparent to-black/30"></div>
                <div class="absolute inset-0 bg-gradient-to-r from-[#060A10]/60 via-transparent to-transparent"></div>

                <!-- Floating High-Precision Badges -->
                <div class="absolute bottom-6 left-6 right-6 flex flex-wrap items-center justify-between gap-4">
                    <div class="glass-panel px-5 py-3 rounded-xl border border-white/15 backdrop-blur-xl shadow-lg flex items-center gap-4">
                        <div class="w-10 h-10 rounded-lg bg-amber-500/10 border border-amber-500/30 flex items-center justify-center text-amber-400">
                            <span class="material-symbols-outlined text-xl">account_balance</span>
                        </div>
                        <div>
                            <div class="text-[10px] uppercase tracking-widest text-slate-400 font-bold">Venue Sidang Pleno</div>
                            <div class="text-sm font-bold text-white">{{ config('event.venue_name') }}</div>
                        </div>
                    </div>

                    <div class="hidden sm:flex items-center gap-3 glass-panel px-4 py-2.5 rounded-xl border border-white/15">
                        <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                        <span class="text-xs text-slate-300 font-medium">Kapasitas Delegasi Resmi Terbatas • Verifikasi Protokoler</span>
                    </div>
                </div>
            </div>

            <!-- Fine Caption Strip -->
            <div class="px-6 py-3.5 flex flex-wrap items-center justify-between gap-3 text-[11px] text-slate-400 tracking-wide bg-[#090E17] border-t border-white/10">
                <div class="flex items-center gap-2">
                    <span class="w-1.5 h-1.5 rounded-full bg-amber-400"></span>
                    <span>Dokumentasi Sidang Pleno Tingkat Tinggi Forum Investasi Kawasan Ekonomi Khusus</span>
                </div>
                <span class="text-slate-400 font-mono">Pemerintah Republik Indonesia &amp; Dewan Nasional KEK</span>
            </div>
        </div>
    </div>
</section>
