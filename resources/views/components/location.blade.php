<!-- LOCATION & LOGISTICS SECTION: Modern Executive Glassmorphic Venue Presentation -->
<section class="py-24 px-6 lg:px-12 bg-gradient-to-b from-[#060A10] via-[#09111E] to-[#060A10] border-b border-white/10 relative overflow-hidden" id="lokasi">
    <!-- Ambient Lighting Accent -->
    <div class="absolute bottom-10 right-10 w-[500px] h-[500px] bg-blue-600/10 rounded-full blur-[140px] pointer-events-none"></div>

    <div class="max-w-[1360px] mx-auto">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-16 items-start">
            <div class="lg:col-span-5 flex flex-col gap-6">
                <div class="inline-flex items-center gap-2 text-xs uppercase tracking-widest text-amber-400 font-bold">
                    <span class="w-2.5 h-1 rounded-full bg-amber-400"></span>
                    <span>Pusat Konvensi Resmi</span>
                </div>
                <h2 class="font-serif text-3xl sm:text-4xl lg:text-5xl font-extrabold text-white tracking-tight leading-tight">
                    Akomodasi &amp; Protokol Delegasi
                </h2>
                <p class="text-sm sm:text-base text-slate-300 leading-relaxed font-normal">
                    Seluruh rangkaian sidang pleno dan bilateral matchmaking diselenggarakan di pusat distrik pemerintahan dan bisnis ibu kota dengan standar pengamanan dan layanan protokoler internasional.
                </p>

                <!-- Logistics Glass Cards List -->
                <div class="space-y-4 pt-2">
                    <div class="glass-panel p-5 rounded-2xl border border-white/10 hover:border-amber-400/30 transition-colors">
                        <div class="flex items-center gap-3 mb-1">
                            <span class="material-symbols-outlined text-amber-400 text-lg">location_city</span>
                            <span class="text-xs uppercase tracking-wider font-bold text-white">Alamat Konvensi</span>
                        </div>
                        <p class="text-xs sm:text-sm text-slate-300 leading-relaxed pl-7">{{ config('event.venue_name') }}, {{ config('event.venue_address') }}</p>
                    </div>

                    <div class="glass-panel p-5 rounded-2xl border border-white/10 hover:border-blue-400/30 transition-colors">
                        <div class="flex items-center gap-3 mb-1">
                            <span class="material-symbols-outlined text-blue-400 text-lg">airport_shuttle</span>
                            <span class="text-xs uppercase tracking-wider font-bold text-white">Transportasi Delegasi VIP</span>
                        </div>
                        <p class="text-xs sm:text-sm text-slate-300 leading-relaxed pl-7">Layanan shuttle resmi beroperasi berkala dari Bandara Internasional Soekarno-Hatta (CGK) Terminal 3 menuju venue dan hotel rekanan resmi.</p>
                    </div>

                    <div class="glass-panel p-5 rounded-2xl border border-white/10 hover:border-emerald-400/30 transition-colors">
                        <div class="flex items-center gap-3 mb-1">
                            <span class="material-symbols-outlined text-emerald-400 text-lg">hotel</span>
                            <span class="text-xs uppercase tracking-wider font-bold text-white">Hotel Rekanan Terakreditasi</span>
                        </div>
                        <p class="text-xs sm:text-sm text-slate-300 leading-relaxed pl-7">The Sultan Hotel &amp; Fairmont Jakarta. Tarif korporat khusus tersedia dengan menyertakan kode registrasi delegasi.</p>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-7">
                <!-- Atmospheric Venue Presentation with Glowing Frame -->
                <div class="relative w-full aspect-[16/10] glass-panel rounded-2xl border border-white/15 overflow-hidden shadow-2xl group">
                    <img 
                        src="{{ asset('images/kek/venue-jcc.jpg') }}" 
                        alt="Venue {{ config('event.venue_hint') }}" 
                        class="w-full h-full object-cover filter brightness-90 contrast-105 group-hover:scale-105 transition-transform duration-700 ease-out"
                        loading="lazy"
                    />
                    <div class="absolute inset-0 bg-gradient-to-t from-[#060A10] via-transparent to-black/20"></div>

                    <!-- Bottom Glass Banner -->
                    <div class="absolute bottom-4 inset-x-4 glass-panel p-4 rounded-xl border border-white/15 text-xs flex flex-wrap items-center justify-between gap-2 shadow-xl">
                        <div class="flex items-center gap-2">
                            <span class="material-symbols-outlined text-amber-400 text-base">meeting_room</span>
                            <span class="font-bold text-white">Grand Ballroom Nusantara &amp; Bilateral Suites</span>
                        </div>
                        <span class="text-slate-300 flex items-center gap-1.5 font-medium">
                            <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                            <span>Pintu Masuk Barat &amp; Jalur VIP Protokoler</span>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
