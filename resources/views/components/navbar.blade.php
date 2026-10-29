<!-- NAVIGATION BAR: Modern Executive Glassmorphic Header with Official KEK Branding -->
<header class="sticky top-0 z-50 bg-[#060A10]/85 backdrop-blur-xl border-b border-white/10 transition-all duration-300">
    <div class="max-w-[1360px] mx-auto px-6 lg:px-12 h-20 flex items-center justify-between">
        <!-- Official KEK Logo & Event Title -->
        <a class="flex items-center gap-3.5 group" href="{{ url('/') }}" id="nav-brand-logo">
            <!-- Official KEK Logo from kek.go.id -->
            <img 
                src="{{ asset('images/kek/logo-kek-white.png') }}" 
                alt="Dewan Nasional Kawasan Ekonomi Khusus" 
                class="h-8 sm:h-9 w-auto object-contain transition-transform duration-300 group-hover:scale-105"
            >
            <div class="h-6 w-px bg-white/20 hidden sm:block"></div>
            <div class="flex flex-col">
                <span class="text-xs sm:text-sm font-bold tracking-[0.14em] uppercase text-white font-serif group-hover:text-amber-300 transition-colors">
                    {{ strtoupper(config('event.name')) }} {{ config('event.year') }}
                </span>
                <span class="text-[10px] tracking-widest uppercase text-slate-400 font-medium hidden sm:block">
                    Akselerasi Investasi Strategis
                </span>
            </div>
        </a>

        <!-- Minimalist Editorial Navigation Links (Desktop) -->
        <nav class="hidden md:flex items-center gap-2 text-[13px] tracking-wide font-medium text-slate-300" id="nav-desktop-menu">
            <a class="px-3.5 py-1.5 rounded-full hover:text-white hover:bg-white/5 transition-all duration-200" href="#tentang">Tentang Forum</a>
            <a class="px-3.5 py-1.5 rounded-full hover:text-white hover:bg-white/5 transition-all duration-200" href="#agenda">Agenda</a>
            <a class="px-3.5 py-1.5 rounded-full hover:text-white hover:bg-white/5 transition-all duration-200" href="#lokasi">Lokasi</a>
            <a class="px-3 py-1.5 text-xs text-slate-400 hover:text-amber-300 flex items-center gap-1 transition-colors ml-2" href="{{ route('staff.login') }}" title="Portal Khusus Petugas Registrasi">
                <span class="material-symbols-outlined text-sm">lock</span>
                <span>Portal Staf</span>
            </a>
        </nav>

        <!-- Refined Registration CTA & Mobile Toggle -->
        <div class="flex items-center gap-4">
            <a 
                id="nav-cta-register"
                class="inline-flex items-center justify-center px-5 py-2.5 rounded-full gold-gradient-btn text-xs font-bold uppercase tracking-wider shadow-lg shadow-amber-500/20 hover:shadow-amber-500/40 transition-all duration-200"
                href="{{ Route::has('registration.index') ? route('registration.index') : '#registrasi' }}"
            >
                <span>Daftar Sekarang</span>
                <span class="material-symbols-outlined text-sm ml-1">arrow_forward</span>
            </a>

            <!-- Mobile Hamburger Button -->
            <button 
                type="button" 
                id="mobile-menu-toggle"
                class="md:hidden text-slate-300 hover:text-white focus:outline-none p-2 rounded-lg hover:bg-white/5 transition-colors"
                aria-label="Buka menu navigasi"
                onclick="document.getElementById('mobile-drawer').classList.toggle('hidden')"
            >
                <span class="material-symbols-outlined text-2xl">menu</span>
            </button>
        </div>
    </div>

    <!-- Mobile Drawer Navigation -->
    <div id="mobile-drawer" class="hidden md:hidden bg-[#0a1017]/95 backdrop-blur-2xl border-b border-white/10 px-6 py-5 space-y-3 shadow-2xl">
        <a class="block py-2.5 text-sm text-slate-300 hover:text-white border-b border-white/5 font-medium" href="#tentang" onclick="document.getElementById('mobile-drawer').classList.add('hidden')">Tentang Forum</a>
        <a class="block py-2.5 text-sm text-slate-300 hover:text-white border-b border-white/5 font-medium" href="#agenda" onclick="document.getElementById('mobile-drawer').classList.add('hidden')">Agenda</a>
        <a class="block py-2.5 text-sm text-slate-300 hover:text-white border-b border-white/5 font-medium" href="#lokasi" onclick="document.getElementById('mobile-drawer').classList.add('hidden')">Lokasi</a>
        <a class="block py-2.5 text-sm text-amber-400 hover:text-amber-300 font-medium flex items-center gap-1.5" href="{{ route('staff.login') }}">
            <span class="material-symbols-outlined text-base">lock</span>
            <span>Masuk Portal Staf</span>
        </a>
    </div>
</header>
