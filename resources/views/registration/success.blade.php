@extends('layouts.app')

@section('title', 'Konfirmasi Registrasi Delegasi — ' . config('event.name'))

@section('content')
<div class="w-full bg-[#060A10] text-white py-16 px-4 sm:px-6 lg:px-12 min-h-[85vh] flex items-center justify-center relative overflow-hidden">
    <!-- Ambient Gold Glow Center -->
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[700px] h-[500px] bg-amber-500/10 rounded-full blur-[160px] pointer-events-none -z-10"></div>

    <div class="max-w-[780px] w-full glass-panel p-8 sm:p-12 rounded-3xl border border-white/15 shadow-2xl relative overflow-hidden backdrop-blur-2xl">
        <!-- Top Gold Gradient Strip -->
        <div class="absolute top-0 inset-x-0 h-1.5 bg-gradient-to-r from-transparent via-amber-400 to-transparent"></div>

        <div class="text-center space-y-4">
            <div class="w-16 h-16 rounded-2xl bg-amber-500/20 border border-amber-500/40 text-amber-400 flex items-center justify-center mx-auto mb-2 shadow-lg shadow-amber-500/20">
                <span class="material-symbols-outlined text-4xl font-bold">check_circle</span>
            </div>
            <div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full glass-panel border border-amber-500/30 text-amber-400 text-xs font-bold uppercase tracking-widest">
                <span>Registrasi Delegasi Berhasil Diserahkan</span>
            </div>
            <h1 class="font-serif text-3xl sm:text-4xl lg:text-5xl font-extrabold text-white tracking-tight">
                Permohonan Akreditasi Diterima
            </h1>
            <p class="text-sm sm:text-base text-slate-300 max-w-lg mx-auto leading-relaxed font-normal">
                Terima kasih. Permohonan akreditasi delegasi Anda telah tercatat resmi di basis data {{ config('event.name') }} {{ $registration->event->year }}.
            </p>
        </div>

        <!-- Registration & Ticket Code Display Card -->
        <div class="mt-8 glass-panel p-6 sm:p-8 rounded-2xl border border-white/10 text-center relative overflow-hidden bg-white/5">
            <div class="text-[11px] uppercase tracking-widest text-slate-400 font-bold mb-1">Nomor Registrasi Resmi (Registration Reference)</div>
            <div class="font-mono text-3xl sm:text-4xl font-extrabold tracking-widest gold-gradient-text" id="confirmation-code">
                {{ $registration->registration_code }}
            </div>

            @if($registration->ticket)
                <div class="mt-2.5 text-xs text-slate-300 font-medium">
                    Nomor E-Badge: <span class="font-mono font-bold text-white">{{ $registration->ticket->ticket_number }}</span>
                </div>
            @endif

            <div class="mt-4 inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-blue-500/20 border border-blue-500/30 text-blue-300 text-xs font-bold uppercase tracking-wider">
                <span class="w-2 h-2 rounded-full bg-amber-400 animate-pulse"></span>
                <span>Status: Menunggu Verifikasi Protokoler</span>
            </div>
        </div>

        <!-- Primary Action: Open Digital Ticket Button -->
        @if($signedTicketUrl)
            <div class="mt-6 p-6 rounded-2xl glass-panel border border-amber-500/30 flex flex-col sm:flex-row items-center justify-between gap-5 text-center sm:text-left bg-gradient-to-r from-amber-500/10 via-transparent to-transparent shadow-xl">
                <div>
                    <div class="text-xs font-bold uppercase tracking-wider text-amber-400 flex items-center gap-2 justify-center sm:justify-start">
                        <span class="material-symbols-outlined text-lg">qr_code_2</span>
                        <span>E-Badge &amp; Tiket Digital Siap Digunakan</span>
                    </div>
                    <p class="text-xs text-slate-300 mt-1 font-normal">
                        Akses kartu delegasi digital ber-QR code untuk proses check-in saat kedatangan.
                    </p>
                </div>
                <a 
                    href="{{ $signedTicketUrl }}" 
                    target="_blank"
                    id="btn-view-ticket"
                    class="w-full sm:w-auto px-7 py-3.5 rounded-xl gold-gradient-btn text-xs font-bold uppercase tracking-wider flex items-center justify-center gap-2 shadow-xl shadow-amber-500/25 hover:shadow-amber-500/40 transition-all whitespace-nowrap"
                >
                    <span>Buka E-Badge</span>
                    <span class="material-symbols-outlined text-base">arrow_forward</span>
                </a>
            </div>
        @endif

        <!-- Email Delivery Status Notification -->
        <div class="mt-6 p-5 rounded-2xl glass-panel border border-white/10 text-xs">
            <div class="flex items-start gap-3">
                <div class="w-8 h-8 rounded-lg bg-amber-500/10 border border-amber-500/30 flex items-center justify-center text-amber-400 flex-shrink-0">
                    <span class="material-symbols-outlined text-lg">mail</span>
                </div>
                <div class="flex-1">
                    <span class="font-bold text-white block mb-0.5 text-xs">Pemberitahuan Pengiriman Email</span>
                    @if(session('resend_status'))
                        <p class="text-emerald-400 font-medium">{{ session('resend_status') }}</p>
                    @elseif($errors->has('resend'))
                        <p class="text-rose-400 font-medium">{{ $errors->first('resend') }}</p>
                    @elseif($latestEmailLog && $latestEmailLog->status === 'sent')
                        <p class="text-slate-300">
                            Konfirmasi dan e-Badge digital telah dikirimkan ke <strong class="text-white">{{ $registration->email }}</strong> pada {{ $latestEmailLog->sent_at?->format('H:i') }} WIB.
                        </p>
                    @elseif($latestEmailLog && $latestEmailLog->status === 'failed')
                        <p class="text-amber-300">
                            Pengiriman email otomatis sedang mengalami kendala. Anda tetap dapat membuka e-Badge melalui tombol di atas atau meminta pengiriman ulang.
                        </p>
                    @else
                        <p class="text-slate-300">
                            Konfirmasi sedang diproses untuk dikirimkan ke <strong class="text-white">{{ $registration->email }}</strong>.
                        </p>
                    @endif
                </div>
            </div>

            <!-- Resend Email Form -->
            <form action="{{ route('registration.resend-email') }}" method="POST" class="mt-4 pt-3 border-t border-white/10 flex flex-col sm:flex-row items-center gap-3">
                @csrf
                <input type="hidden" name="registration_code" value="{{ $registration->registration_code }}">
                <input type="hidden" name="email" value="{{ $registration->email }}">
                <span class="text-[11px] text-slate-400 text-center sm:text-left flex-1 font-normal">
                    Belum menerima email di kotak masuk atau folder spam?
                </span>
                <button 
                    type="submit" 
                    class="px-4 py-2 rounded-lg glass-panel hover:bg-white/10 text-white text-[11px] font-bold uppercase tracking-wider transition-all cursor-pointer whitespace-nowrap border border-white/15"
                >
                    Kirim Ulang Email
                </button>
            </form>
        </div>

        <!-- Summary Details Grid -->
        <div class="mt-8 border-t border-white/10 pt-6">
            <h2 class="text-xs font-bold uppercase tracking-wider text-amber-400 mb-4 flex items-center gap-1.5">
                <span class="material-symbols-outlined text-sm">badge</span>
                <span>Ringkasan Data Delegasi</span>
            </h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                <div class="glass-panel p-3.5 rounded-xl border border-white/10">
                    <span class="text-slate-400 block mb-0.5 text-[11px]">Nama Delegasi:</span>
                    <span class="font-bold text-white text-sm">{{ $registration->full_name }}</span>
                </div>
                <div class="glass-panel p-3.5 rounded-xl border border-white/10">
                    <span class="text-slate-400 block mb-0.5 text-[11px]">Alamat Email:</span>
                    <span class="font-bold text-white text-sm">{{ $registration->email }}</span>
                </div>
                <div class="glass-panel p-3.5 rounded-xl border border-white/10">
                    <span class="text-slate-400 block mb-0.5 text-[11px]">Instansi / Perusahaan:</span>
                    <span class="font-bold text-white text-sm">{{ $registration->company_name }}</span>
                </div>
                <div class="glass-panel p-3.5 rounded-xl border border-white/10">
                    <span class="text-slate-400 block mb-0.5 text-[11px]">Jabatan / Posisi:</span>
                    <span class="font-bold text-white text-sm">{{ $registration->position }}</span>
                </div>
                <div class="glass-panel p-3.5 rounded-xl border border-white/10">
                    <span class="text-slate-400 block mb-0.5 text-[11px]">Kategori Partisipasi:</span>
                    <span class="font-bold text-amber-300 text-sm uppercase">{{ $registration->participation_category }}</span>
                </div>
                <div class="glass-panel p-3.5 rounded-xl border border-white/10">
                    <span class="text-slate-400 block mb-0.5 text-[11px]">Waktu Pengajuan:</span>
                    <span class="font-bold text-white text-sm">{{ $registration->created_at->format('d M Y, H:i') }} WIB</span>
                </div>
            </div>
        </div>

        <!-- Next Protocol Steps -->
        <div class="mt-6 p-4 rounded-xl glass-panel border border-white/10 text-xs text-slate-300 space-y-1.5">
            <div class="font-bold text-white flex items-center gap-2">
                <span class="material-symbols-outlined text-amber-400 text-base">info</span>
                <span>Panduan Check-in Delegasi:</span>
            </div>
            <p class="leading-relaxed text-[11px] text-slate-400 font-normal">
                Simpan nomor registrasi dan unduh atau buka tautan e-Badge di ponsel Anda. Tunjukkan QR code tersebut kepada staf registrasi di meja kedatangan pada hari pelaksanaan forum untuk mencetak kartu tanda pengenal fisik.
            </p>
        </div>

        <!-- Action Links -->
        <div class="mt-8 flex flex-col sm:flex-row items-center justify-between gap-4 pt-4 border-t border-white/10">
            <button 
                type="button" 
                onclick="window.print()" 
                class="w-full sm:w-auto px-6 py-3 rounded-xl glass-panel hover:bg-white/10 text-white text-xs font-bold uppercase tracking-wider flex items-center justify-center gap-2 transition-all cursor-pointer border border-white/15"
            >
                <span class="material-symbols-outlined text-base">print</span>
                <span>Cetak Tanda Terima</span>
            </button>
            <a 
                href="{{ url('/') }}" 
                class="w-full sm:w-auto px-7 py-3 rounded-xl gold-gradient-btn text-xs font-bold uppercase tracking-wider flex items-center justify-center gap-2 transition-all shadow-md shadow-amber-500/20"
            >
                <span>Kembali ke Beranda</span>
                <span class="material-symbols-outlined text-base">home</span>
            </a>
        </div>
    </div>
</div>
@endsection
