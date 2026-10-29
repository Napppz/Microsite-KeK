<!-- UNDERSTATED AUTHORITATIVE FOOTER -->
<footer class="bg-[#04070B] text-slate-400 border-t border-white/10 py-16 px-6 lg:px-12 text-xs font-sans relative overflow-hidden" id="footer">
    <!-- Subtle Ambient Glow -->
    <div class="absolute bottom-0 left-1/3 w-96 h-96 bg-amber-500/5 rounded-full blur-[120px] pointer-events-none"></div>

    <div class="max-w-[1360px] mx-auto grid grid-cols-1 md:grid-cols-12 gap-10 pb-12 border-b border-white/10">
        <div class="md:col-span-5 flex flex-col gap-4">
            <!-- Official KEK Logo from kek.go.id -->
            <div>
                <img 
                    src="{{ asset('images/kek/logo-kek-white.png') }}" 
                    alt="Dewan Nasional Kawasan Ekonomi Khusus" 
                    class="h-9 w-auto object-contain mb-2"
                >
            </div>
            <div class="flex items-center gap-2.5">
                <span class="text-sm font-bold tracking-wider uppercase text-white font-serif">
                    {{ strtoupper(config('event.name')) }} {{ config('event.year') }}
                </span>
            </div>
            <p class="text-slate-400 leading-relaxed max-w-md font-normal">
                Penyelenggaraan resmi di bawah koordinasi {{ config('event.organizer') }}, {{ config('event.ministry') }} Republik Indonesia.
            </p>
            <div class="flex items-center gap-3 pt-2 text-[11px] text-slate-500">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full glass-panel border border-white/10 text-slate-300">
                    <span class="material-symbols-outlined text-emerald-400 text-sm">lock</span>
                    <span>256-Bit SSL Enkripsi Terverifikasi</span>
                </span>
            </div>
        </div>
        <div class="md:col-span-3 flex flex-col gap-3">
            <span class="text-white text-[11px] font-bold uppercase tracking-wider text-amber-400">Sekretariat Pelaksana</span>
            <p class="leading-relaxed text-slate-400">
                Gedung Ali Wardhana Lantai 4<br/>
                Jl. Lapangan Banteng Timur No. 2–4<br/>
                Jakarta Pusat 10710, Indonesia
            </p>
        </div>
        <div class="md:col-span-4 flex flex-col gap-3">
            <span class="text-white text-[11px] font-bold uppercase tracking-wider text-amber-400">Hubungi Panitia &amp; Bantuan</span>
            <p class="leading-relaxed text-slate-400">
                Surel Resmi: <a class="text-white hover:text-amber-300 transition-colors" href="mailto:info@kek.go.id">info@kek.go.id</a> / <a class="text-white hover:text-amber-300 transition-colors" href="mailto:forum@kek.go.id">forum@kek.go.id</a><br/>
                Telepon: +62 21 352 1970 (Meja Bantuan Delegasi Internasional)
            </p>
        </div>
    </div>
    <div class="max-w-[1360px] mx-auto pt-8 flex flex-col md:flex-row items-center justify-between gap-4 text-[11px] text-slate-400">
        <p>© {{ config('event.year') }} Sekretariat Jenderal Dewan Nasional KEK Republik Indonesia. Hak Cipta Dilindungi Undang-Undang.</p>
        <div class="flex items-center gap-6">
            <a class="hover:text-white transition-colors" href="#">Protokol Keamanan</a>
            <a class="hover:text-white transition-colors" href="#">Kebijakan Privasi Delegasi</a>
            <a class="hover:text-white transition-colors" href="#">Pedoman Acara Resmi</a>
        </div>
    </div>
</footer>
