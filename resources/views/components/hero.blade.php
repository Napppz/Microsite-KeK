<!-- HERO SECTION: World Economic Forum / Davos Style Executive Summit Hero -->
<section class="relative bg-gradient-to-b from-[#060A10] via-[#09111E] to-[#060A10] text-white pt-16 pb-24 px-6 lg:px-12 border-b border-white/10 overflow-hidden" id="hero">
    <!-- Subtle Ambient Radial Glow Behind Hero -->
    <div class="absolute top-1/4 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[800px] h-[400px] bg-gradient-to-r from-amber-500/10 via-blue-600/15 to-purple-600/10 rounded-full blur-[140px] pointer-events-none -z-10"></div>

    <div class="max-w-[1360px] mx-auto">
        <!-- Monumental Editorial Headline & Value Prop -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-end pb-16 pt-4">
            <div class="lg:col-span-8">
                <h1 class="font-serif text-4xl sm:text-6xl lg:text-[70px] leading-[1.08] font-extrabold tracking-tight text-white">
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
                        class="inline-flex items-center gap-2.5 px-7 py-3.5 rounded-full gold-gradient-btn text-xs font-bold uppercase tracking-wider shadow-xl shadow-amber-500/25 hover:shadow-amber-500/40 transition-all duration-200"
                        href="{{ Route::has('registration.index') ? route('registration.index') : '#registrasi' }}"
                    >
                        <span>Daftar Delegasi</span>
                        <span class="material-symbols-outlined text-base">arrow_forward</span>
                    </a>
                    <a 
                        id="hero-cta-agenda"
                        class="inline-flex items-center gap-2 px-6 py-3.5 rounded-full glass-panel hover:bg-white/10 text-white text-xs font-semibold uppercase tracking-wider transition-all duration-200 border border-white/15 hover:border-white/30"
                        href="#agenda"
                    >
                        <span>Lihat Jadwal Pleno</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Cinematic Summit Photography Block with Glassmorphic Floating Cards -->
        <div class="relative w-full overflow-hidden rounded-2xl border border-white/15 shadow-2xl glass-panel group">
            <div class="relative aspect-[16/9] lg:aspect-[23/10] w-full bg-[#0d1624] overflow-hidden">
                <img 
                    id="hero-summit-image"
                    alt="Sidang Pleno KEK Business Forum {{ config('event.year') }}" 
                    class="w-full h-full object-cover filter brightness-90 contrast-105 group-hover:scale-105 transition-transform duration-700 ease-out" 
                    src="{{ asset('images/kek/hero-plenary.jpg') }}"
                    loading="eager"
                />
                <!-- Gradient overlays for depth -->
                <div class="absolute inset-0 bg-gradient-to-t from-[#060A10] via-transparent to-black/30"></div>
                <div class="absolute inset-0 bg-gradient-to-r from-[#060A10]/70 via-transparent to-transparent"></div>

                <!-- Floating Glassmorphic Stat Badges -->
                <div class="absolute bottom-6 left-6 right-6 flex flex-wrap items-center justify-between gap-4">
                    <div class="glass-panel px-5 py-3 rounded-xl border border-white/15 backdrop-blur-xl shadow-lg flex items-center gap-4">
                        <div class="w-10 h-10 rounded-lg bg-amber-500/20 border border-amber-500/30 flex items-center justify-center text-amber-400">
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
            <div class="px-6 py-3.5 flex flex-wrap items-center justify-between gap-3 text-[11px] text-slate-400 tracking-wide bg-[#060A10]/90 border-t border-white/10">
                <div class="flex items-center gap-2">
                    <span class="w-1.5 h-1.5 rounded-full bg-amber-400"></span>
                    <span>Dokumentasi Sidang Pleno Tingkat Tinggi Forum Investasi Kawasan Ekonomi Khusus</span>
                </div>
                <span class="text-slate-400 font-medium">Pemerintah Republik Indonesia &amp; Dewan Nasional KEK</span>
            </div>
        </div>
    </div>
</section>
