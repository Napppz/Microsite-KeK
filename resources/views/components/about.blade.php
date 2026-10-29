<!-- EDITORIAL INTRODUCTION: World Economic Forum Style Strategic Insights -->
<section class="py-24 px-6 lg:px-12 bg-gradient-to-b from-[#060A10] via-[#09111E] to-[#060A10] border-b border-white/10 relative overflow-hidden" id="tentang">
    <!-- Ambient Glow Accent -->
    <div class="absolute bottom-10 right-1/4 w-[500px] h-[500px] bg-amber-500/5 rounded-full blur-[140px] pointer-events-none"></div>

    <div class="max-w-[1360px] mx-auto">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-16 items-start">
            <!-- Left: Hero Statement & 22+ KEK Anchor -->
            <div class="lg:col-span-5 flex flex-col gap-6">
                <div class="inline-flex items-center gap-2 text-xs uppercase tracking-widest text-amber-400 font-bold">
                    <span class="w-2.5 h-1 rounded-full bg-amber-400"></span>
                    <span>Tujuan &amp; Urgensi Forum</span>
                </div>
                <h2 class="font-serif text-3xl sm:text-4xl lg:text-[42px] leading-[1.15] font-bold tracking-tight text-white">
                    Menghubungkan kepastian regulasi dengan realisasi permodalan global dalam satu meja perundingan.
                </h2>
                <div class="glass-panel p-6 rounded-2xl border border-white/10 flex items-center gap-6 mt-2">
                    <span class="font-serif text-5xl sm:text-6xl font-extrabold gold-gradient-text tracking-tight">22+</span>
                    <p class="text-xs sm:text-sm text-slate-300 leading-relaxed font-normal">
                        Kawasan Ekonomi Khusus aktif di seluruh koridor maritim dan sentra industri manufaktur Indonesia yang siap menyerap modal jangka panjang.
                    </p>
                </div>
            </div>

            <!-- Right: Two Strategic Glassmorphic Pillar Cards -->
            <div class="lg:col-span-7 grid grid-cols-1 sm:grid-cols-2 gap-6">
                <!-- Pillar 1 -->
                <div class="glass-panel glass-panel-hover p-7 rounded-2xl border border-white/10 relative overflow-hidden flex flex-col justify-between">
                    <div>
                        <div class="w-10 h-10 rounded-xl bg-amber-500/10 border border-amber-500/30 text-amber-400 flex items-center justify-center mb-5">
                            <span class="material-symbols-outlined text-2xl">hub</span>
                        </div>
                        <h3 class="text-base font-bold text-white mb-3 tracking-wide">
                            Hilirisasi &amp; Rantai Pasok Berkelanjutan
                        </h3>
                        <p class="text-sm text-slate-300 leading-relaxed mb-4">
                            Kawasan Ekonomi Khusus bukan semata hamparan lahan industri, melainkan simpul ekosistem terpadu yang dirancang untuk meningkatkan nilai tambah komoditas mineral, energi bersih, hilirisasi agrikultur, dan manufaktur berteknologi tinggi.
                        </p>
                    </div>
                    <div class="pt-4 border-t border-white/10 text-xs text-amber-300 font-medium flex items-center gap-1.5">
                        <span class="material-symbols-outlined text-sm">security</span>
                        <span>Kepastian Hukum &amp; Insentif Riil</span>
                    </div>
                </div>

                <!-- Pillar 2 -->
                <div class="glass-panel glass-panel-hover p-7 rounded-2xl border border-white/10 relative overflow-hidden flex flex-col justify-between">
                    <div>
                        <div class="w-10 h-10 rounded-xl bg-blue-500/10 border border-blue-500/30 text-blue-400 flex items-center justify-center mb-5">
                            <span class="material-symbols-outlined text-2xl">speed</span>
                        </div>
                        <h3 class="text-base font-bold text-white mb-3 tracking-wide">
                            Penyederhanaan Tata Kelola Satu Pintu
                        </h3>
                        <p class="text-sm text-slate-300 leading-relaxed mb-4">
                            Pemerintah menegaskan komitmen perizinan tanpa hambatan melalui pemutakhiran sistem Online Single Submission (OSS) KEK dan kewenangan desentralistik administrator kawasan untuk percepatan perizinan berusaha, impor mesin modal, serta keimigrasian tenaga ahli.
                        </p>
                    </div>
                    <div class="pt-4 border-t border-white/10 text-xs text-blue-300 font-medium flex items-center gap-1.5">
                        <span class="material-symbols-outlined text-sm">verified_user</span>
                        <span>Sistem OSS Terpadu &amp; Jalur Hijau</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Metric Anchors Strip: 4 Floating Glowing Stats -->
        <div class="mt-16 pt-10 border-t border-white/10 grid grid-cols-2 md:grid-cols-4 gap-6">
            <div class="glass-panel p-5 rounded-2xl border border-white/10">
                <span class="block text-[11px] font-bold uppercase tracking-wider text-slate-400 mb-1">Target Investasi</span>
                <div class="font-serif text-3xl font-extrabold text-white gold-gradient-text">{{ config('event.target_investment') }}</div>
                <span class="text-xs text-slate-400 mt-1 block">Komitmen modal tahun {{ config('event.year') }}</span>
            </div>
            <div class="glass-panel p-5 rounded-2xl border border-white/10">
                <span class="block text-[11px] font-bold uppercase tracking-wider text-slate-400 mb-1">Delegasi Multinasional</span>
                <div class="font-serif text-3xl font-extrabold text-white">{{ config('event.target_delegates') }}</div>
                <span class="text-xs text-slate-400 mt-1 block">Mitra dagang dan korporasi global</span>
            </div>
            <div class="glass-panel p-5 rounded-2xl border border-white/10">
                <span class="block text-[11px] font-bold uppercase tracking-wider text-slate-400 mb-1">Fasilitas Fiskal</span>
                <div class="font-serif text-3xl font-extrabold text-amber-400">{{ config('event.fiscal_facility') }}</div>
                <span class="text-xs text-slate-400 mt-1 block">Tax Holiday &amp; pembebasan bea masuk</span>
            </div>
            <div class="glass-panel p-5 rounded-2xl border border-white/10">
                <span class="block text-[11px] font-bold uppercase tracking-wider text-slate-400 mb-1">Sesi Bilateral</span>
                <div class="font-serif text-3xl font-extrabold text-white">{{ config('event.bilateral_sessions') }}</div>
                <span class="text-xs text-slate-400 mt-1 block">Ruang perundingan tertutup &amp; MoU</span>
            </div>
        </div>
    </div>
</section>
