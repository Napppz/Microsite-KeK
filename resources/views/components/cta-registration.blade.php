<!-- DIGNIFIED CLOSING CTA & REGISTRATION ACCREDITATION -->
<section class="py-24 px-6 lg:px-12 bg-gradient-to-b from-[#060A10] via-[#0B1320] to-[#060A10] text-white relative overflow-hidden" id="registrasi">
    <!-- Ambient Gold Glow Center -->
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[700px] h-[500px] bg-amber-500/10 rounded-full blur-[160px] pointer-events-none -z-10"></div>

    <div class="max-w-[960px] mx-auto text-center flex flex-col items-center">
        <!-- Badge -->
        <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full glass-panel border border-amber-500/30 text-amber-400 text-xs font-bold uppercase tracking-widest mb-6">
            <span class="w-2 h-2 rounded-full bg-amber-400 animate-pulse"></span>
            <span>Akreditasi &amp; Partisipasi</span>
        </div>

        <h2 class="font-serif text-3xl sm:text-5xl lg:text-6xl font-extrabold tracking-tight text-white mb-6 leading-tight">
            Konfirmasi Kehadiran Delegasi Resmi Anda
        </h2>
        <p class="text-sm sm:text-base text-slate-300 max-w-2xl leading-relaxed mb-10 font-normal">
            Partisipasi dalam sidang pleno dan sesi bilateral {{ config('event.name') }} {{ config('event.year') }} dibuka terbatas untuk perwakilan korporasi, institusi keuangan, dan otoritas pengembang kawasan yang memenuhi kriteria verifikasi kesekretariatan.
        </p>

        <!-- Inline Glassmorphic Registration Trigger Card -->
        <div class="w-full max-w-xl glass-panel p-8 sm:p-10 rounded-3xl border border-white/15 shadow-2xl text-left relative overflow-hidden backdrop-blur-2xl">
            <!-- Subtle gradient border line on top -->
            <div class="absolute top-0 inset-x-0 h-1 bg-gradient-to-r from-transparent via-amber-400 to-transparent"></div>

            <form 
                id="registration-trigger-form"
                class="space-y-4" 
                method="GET"
                action="{{ route('registration.create') }}"
            >
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-2 flex items-center gap-1.5" for="reg-name">
                        <span class="material-symbols-outlined text-sm text-amber-400">person</span>
                        <span>Nama Lengkap &amp; Gelar</span>
                    </label>
                    <input 
                        id="reg-name"
                        name="full_name"
                        class="w-full bg-white/5 border border-white/15 px-4 py-3 text-sm text-white placeholder-slate-500 focus:outline-none focus:border-amber-400 focus:ring-1 focus:ring-amber-400 rounded-xl transition-all font-medium" 
                        placeholder="Contoh: Dr. Ir. Budi Santoso, M.B.A." 
                        required 
                        type="text"
                    />
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-2 flex items-center gap-1.5" for="reg-institution">
                        <span class="material-symbols-outlined text-sm text-amber-400">domain</span>
                        <span>Instansi / Perusahaan</span>
                    </label>
                    <input 
                        id="reg-institution"
                        name="company_name"
                        class="w-full bg-white/5 border border-white/15 px-4 py-3 text-sm text-white placeholder-slate-500 focus:outline-none focus:border-amber-400 focus:ring-1 focus:ring-amber-400 rounded-xl transition-all font-medium" 
                        placeholder="Nama korporasi atau badan usaha" 
                        required 
                        type="text"
                    />
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-2 flex items-center gap-1.5" for="reg-email">
                        <span class="material-symbols-outlined text-sm text-amber-400">mail</span>
                        <span>Alamat Surel Resmi Korporat</span>
                    </label>
                    <input 
                        id="reg-email"
                        name="email"
                        class="w-full bg-white/5 border border-white/15 px-4 py-3 text-sm text-white placeholder-slate-500 focus:outline-none focus:border-amber-400 focus:ring-1 focus:ring-amber-400 rounded-xl transition-all font-medium" 
                        placeholder="delegasi@perusahaan.com" 
                        required 
                        type="email"
                    />
                </div>
                <button 
                    id="reg-submit-btn"
                    class="w-full py-4 gold-gradient-btn text-xs font-bold uppercase tracking-wider rounded-xl transition-all duration-200 mt-4 cursor-pointer flex items-center justify-center gap-2 shadow-lg shadow-amber-500/25 hover:shadow-amber-500/40" 
                    type="submit"
                >
                    <span>Lanjutkan ke Formulir Akreditasi</span>
                    <span class="material-symbols-outlined text-base">arrow_forward</span>
                </button>
            </form>
        </div>

        <p class="text-xs text-slate-400 max-w-lg leading-relaxed mt-8 font-normal flex items-center justify-center gap-2">
            <span class="material-symbols-outlined text-emerald-400 text-sm">verified_user</span>
            <span>Setelah diverifikasi, e-Badge ber-QR Code keamanan terenkripsi akan diterbitkan via surel resmi.</span>
        </p>
    </div>
</section>
