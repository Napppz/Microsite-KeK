<!-- EXECUTIVE ACCREDITATION CTA & REGISTRATION TRIGGER -->
<section class="py-24 px-6 lg:px-12 bg-[#060A10] bg-dot-matrix text-white relative overflow-hidden" id="registrasi">
    <!-- Subtle Ambient Glow -->
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[700px] h-[350px] bg-gradient-to-b from-[#1E3A8A]/10 via-[#F59E0B]/08 to-transparent rounded-full blur-[150px] pointer-events-none -z-10"></div>

    <div class="max-w-[960px] mx-auto text-center flex flex-col items-center">
        <!-- Badge -->
        <div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-white/[0.04] border border-white/10 text-amber-400 text-xs font-mono font-bold uppercase tracking-widest mb-6">
            <span class="w-2 h-2 rounded-full bg-amber-400 animate-pulse"></span>
            <span>Akreditasi &amp; Partisipasi</span>
        </div>

        <h2 class="font-serif text-3xl sm:text-5xl lg:text-6xl font-extrabold tracking-tight text-white mb-6 leading-tight">
            Konfirmasi Kehadiran Delegasi Resmi Anda
        </h2>
        <p class="text-sm sm:text-base text-slate-300 max-w-2xl leading-relaxed mb-10 font-normal">
            Partisipasi dalam sidang pleno dan sesi bilateral {{ config('event.name') }} {{ config('event.year') }} dibuka terbatas untuk perwakilan korporasi, institusi keuangan, dan otoritas pengembang kawasan yang memenuhi kriteria verifikasi kesekretariatan.
        </p>

        <!-- Mastercrafted Accreditation Trigger Card -->
        <div class="w-full max-w-xl pro-card p-8 sm:p-10 rounded-3xl border border-white/15 shadow-[0_25px_60px_-15px_rgba(0,0,0,0.8)] text-left relative overflow-hidden">
            <!-- Subtle Top Ribbon -->
            <div class="absolute top-0 inset-x-0 h-1 bg-gradient-to-r from-transparent via-[#F59E0B] to-transparent"></div>

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
                        class="w-full bg-white/[0.03] border border-white/15 px-4 py-3 text-sm text-white placeholder-slate-500 focus:outline-none focus:border-amber-400 focus:ring-2 focus:ring-amber-400/20 rounded-xl transition-all font-medium" 
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
                        class="w-full bg-white/[0.03] border border-white/15 px-4 py-3 text-sm text-white placeholder-slate-500 focus:outline-none focus:border-amber-400 focus:ring-2 focus:ring-amber-400/20 rounded-xl transition-all font-medium" 
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
                        class="w-full bg-white/[0.03] border border-white/15 px-4 py-3 text-sm text-white placeholder-slate-500 focus:outline-none focus:border-amber-400 focus:ring-2 focus:ring-amber-400/20 rounded-xl transition-all font-medium" 
                        placeholder="delegasi@perusahaan.com" 
                        required 
                        type="email"
                    />
                </div>
                <button 
                    id="reg-submit-btn"
                    class="w-full py-4 gold-gradient-btn text-xs font-bold uppercase tracking-wider rounded-xl transition-all duration-200 mt-4 cursor-pointer flex items-center justify-center gap-2 shadow-lg hover:shadow-amber-500/30" 
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
