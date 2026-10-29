@extends('layouts.app')

@section('title', 'Masuk Petugas Meja Registrasi — ' . config('event.name'))

@section('content')
<div class="w-full bg-[#060A10] text-white py-16 px-4 sm:px-6 lg:px-8 min-h-[85vh] flex items-center justify-center relative overflow-hidden">
    <!-- Ambient Radial Lighting -->
    <div class="absolute top-1/3 left-1/2 -translate-x-1/2 w-[500px] h-[500px] bg-gradient-to-b from-[#D4AF37]/15 to-transparent rounded-full blur-[140px] pointer-events-none -z-10"></div>
    <div class="absolute bottom-10 left-10 w-80 h-80 bg-[#183B5B]/20 rounded-full blur-[120px] pointer-events-none -z-10"></div>

    <div class="max-w-[460px] w-full glass-panel border border-white/15 p-8 sm:p-10 rounded-3xl shadow-[0_25px_60px_-15px_rgba(0,0,0,0.8)] relative overflow-hidden">
        <!-- Top Sovereign Gold Accent Line -->
        <div class="absolute top-0 left-0 right-0 h-1.5 bg-gradient-to-r from-[#D4AF37] via-[#F3E5AB] to-[#C59B27]"></div>

        <div class="text-center space-y-3 mb-8">
            <div class="flex justify-center mb-3">
                <img src="{{ asset('images/kek/logo-kek-white.png') }}" alt="Dewan Nasional KEK" class="h-9 w-auto object-contain">
            </div>
            <span class="text-[10px] uppercase tracking-[0.25em] text-[#D4AF37] font-semibold block">Portal Operasional Acara</span>
            <h1 class="font-display text-2xl sm:text-3xl font-bold text-white tracking-tight">
                Masuk Staf Registrasi
            </h1>
            <p class="text-xs text-slate-400 leading-relaxed font-medium">
                Akses khusus staf dan sekretariat akreditasi {{ config('event.name') }} {{ config('event.year') }}.
            </p>
        </div>

        @if(session('status'))
            <div class="mb-6 p-4 rounded-xl bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 text-xs flex items-center gap-2">
                <span class="material-symbols-outlined text-base">check_circle</span>
                <span>{{ session('status') }}</span>
            </div>
        @endif

        @if($errors->any())
            <div class="mb-6 p-4 rounded-xl bg-rose-500/10 border border-rose-500/30 text-rose-300 text-xs flex items-start gap-2">
                <span class="material-symbols-outlined text-base mt-0.5">error</span>
                <div class="flex-1 space-y-1">
                    @foreach($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Login Form -->
        <form method="POST" action="{{ route('staff.login.store') }}" class="space-y-5" id="staff-login-form">
            @csrf

            <!-- Email Field -->
            <div>
                <label for="email" class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-2">
                    Alamat Email Resmi Staf
                </label>
                <div class="relative">
                    <input 
                        type="email" 
                        name="email" 
                        id="email" 
                        value="{{ old('email') }}" 
                        required 
                        autocomplete="email" 
                        autofocus
                        placeholder="staf@kek.go.id"
                        class="w-full px-4 py-3 bg-white/[0.04] border border-white/15 focus:border-[#D4AF37] focus:ring-2 focus:ring-[#D4AF37]/20 rounded-xl text-sm text-white placeholder-slate-500 transition-all outline-none"
                    >
                </div>
            </div>

            <!-- Password Field with Visibility Toggle -->
            <div>
                <label for="password" class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-2">
                    Kata Sandi
                </label>
                <div class="relative">
                    <input 
                        type="password" 
                        name="password" 
                        id="password" 
                        required 
                        autocomplete="current-password"
                        placeholder="••••••••••••"
                        class="w-full px-4 py-3 pr-11 bg-white/[0.04] border border-white/15 focus:border-[#D4AF37] focus:ring-2 focus:ring-[#D4AF37]/20 rounded-xl text-sm text-white placeholder-slate-500 transition-all outline-none font-sans"
                    >
                    <button 
                        type="button" 
                        id="toggle-password-btn" 
                        aria-label="Tampilkan atau sembunyikan kata sandi"
                        class="absolute right-3.5 top-1/2 -translate-y-1/2 text-slate-400 hover:text-white transition-colors cursor-pointer"
                        onclick="togglePasswordVisibility()"
                    >
                        <span class="material-symbols-outlined text-xl" id="password-visibility-icon">visibility</span>
                    </button>
                </div>
            </div>

            <!-- Remember Me -->
            <div class="flex items-center justify-between text-xs pt-1">
                <label class="flex items-center gap-2.5 cursor-pointer text-slate-300 hover:text-white">
                    <input 
                        type="checkbox" 
                        name="remember" 
                        class="w-4 h-4 rounded border-white/20 bg-white/5 text-[#D4AF37] focus:ring-[#D4AF37]"
                    >
                    <span>Ingat sesi pada perangkat ini</span>
                </label>
            </div>

            <!-- Submit Button -->
            <button 
                type="submit" 
                id="btn-login-submit"
                class="w-full mt-3 py-3.5 px-4 rounded-xl gold-gradient-btn text-black text-xs font-bold uppercase tracking-widest flex items-center justify-center gap-2 transition-all shadow-lg hover:shadow-[#D4AF37]/25 cursor-pointer"
            >
                <span class="material-symbols-outlined text-base">login</span>
                <span>Masuk ke Pemindai Kehadiran</span>
            </button>
        </form>

        <div class="mt-8 pt-6 border-t border-white/10 text-center text-[11px] text-slate-500 font-medium">
            Akses diawasi oleh Protokoler Dewan Nasional KEK &bull; IP: {{ request()->ip() }}
        </div>
    </div>
</div>

<script>
    function togglePasswordVisibility() {
        const input = document.getElementById('password');
        const icon = document.getElementById('password-visibility-icon');
        if (input.type === 'password') {
            input.type = 'text';
            icon.textContent = 'visibility_off';
        } else {
            input.type = 'password';
            icon.textContent = 'visibility';
        }
    }
</script>
@endsection
