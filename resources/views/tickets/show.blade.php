@extends('layouts.app')

@section('title', 'E-Badge & Tiket Delegasi — ' . config('event.name'))

@section('content')
<div class="w-full bg-[#060A10] text-white py-12 md:py-20 px-4 sm:px-6 lg:px-8 min-h-[90vh] flex items-center justify-center relative overflow-hidden">
    <!-- Ambient Executive Radial Glows -->
    <div class="absolute top-1/4 left-1/2 -translate-x-1/2 w-[600px] h-[600px] bg-gradient-to-b from-[#D4AF37]/15 to-transparent rounded-full blur-[140px] pointer-events-none -z-10"></div>
    <div class="absolute bottom-10 right-10 w-96 h-96 bg-[#183B5B]/25 rounded-full blur-[120px] pointer-events-none -z-10"></div>

    <div class="max-w-[620px] w-full">
        
        <!-- Digital Pass Card (Executive Apple Wallet Style) -->
        <div class="glass-panel rounded-3xl border border-white/15 shadow-[0_25px_60px_-15px_rgba(0,0,0,0.7)] overflow-hidden relative print:border-none print:shadow-none print:bg-white print:text-black">
            
            <!-- Top Sovereign Ribbon Accent -->
            <div class="h-2 bg-gradient-to-r from-[#D4AF37] via-[#F3E5AB] to-[#C59B27]"></div>

            <!-- Pass Top Branding & Security Header -->
            <div class="p-6 sm:p-8 border-b border-white/10 text-center relative bg-gradient-to-b from-white/[0.04] to-transparent print:bg-white print:border-b-2 print:border-black">
                
                <!-- Official Logo (White for dark UI, Black for print) -->
                <div class="flex justify-center mb-4">
                    <img src="{{ asset('images/kek/logo-kek-white.png') }}" alt="Dewan Nasional KEK" class="h-8 sm:h-9 w-auto object-contain print:hidden">
                    <img src="{{ asset('images/kek/logo-kek-black.png') }}" alt="Dewan Nasional KEK" class="h-8 sm:h-9 w-auto object-contain hidden print:block">
                </div>

                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/5 border border-[#D4AF37]/30 text-[10px] sm:text-xs uppercase tracking-[0.25em] text-[#D4AF37] font-semibold mb-3 print:text-black print:border-black">
                    <span class="w-2 h-2 rounded-full bg-[#D4AF37] animate-pulse"></span>
                    <span>Official Delegation Pass</span>
                </div>

                <h1 class="font-display text-2xl sm:text-3xl font-bold tracking-tight text-white print:text-black">
                    {{ config('event.name') }} {{ $event->year }}
                </h1>
                <p class="text-xs text-slate-400 mt-1 font-medium print:text-gray-600">
                    {{ config('event.ministry') }}
                </p>

                <div class="mt-4 inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-emerald-500/10 border border-emerald-500/30 text-[11px] font-semibold text-emerald-400 tracking-wider print:border-black print:text-black print:bg-gray-100">
                    <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                    <span>Status: Terbit Resmi (Active Verified)</span>
                </div>
            </div>

            <!-- QR Code Main Display Pod (High-Contrast Precision Scan Area) -->
            <div class="p-6 sm:p-8 bg-white text-slate-900 text-center border-b border-gray-200 relative">
                <div class="text-[11px] uppercase tracking-widest text-slate-500 font-bold mb-1">
                    Nomor Tiket Delegasi
                </div>
                <div class="font-mono text-2xl sm:text-3xl font-extrabold tracking-widest text-[#0C2340] mb-5 selection:bg-[#D4AF37] selection:text-black">
                    {{ $ticket->ticket_number }}
                </div>

                <!-- QR Visual Container -->
                <div class="inline-block p-4 sm:p-5 bg-white border-2 border-slate-200/80 rounded-2xl shadow-[0_10px_25px_-5px_rgba(0,0,0,0.1)] mx-auto mb-4 hover:border-[#D4AF37] transition-colors">
                    <div class="w-[210px] h-[210px] sm:w-[240px] sm:h-[240px] flex items-center justify-center mx-auto [&>svg]:w-full [&>svg]:h-full [&>svg]:block">
                        {!! $qrSvg !!}
                    </div>
                </div>

                <div class="text-xs text-slate-500 font-medium leading-relaxed max-w-sm mx-auto">
                    Tunjukkan kode QR beresolusi tinggi ini kepada staf meja akreditasi kedatangan saat memasuki venue forum.
                </div>
            </div>

            <!-- Participant Info Detailed Section -->
            <div class="p-6 sm:p-8 space-y-4 print:bg-white print:text-black">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5 text-xs">
                    <div class="bg-white/[0.03] p-4 rounded-xl border border-white/10 print:border-gray-300 print:bg-gray-50">
                        <span class="text-slate-400 block text-[11px] font-medium mb-1 print:text-gray-500">Nama Lengkap Delegasi:</span>
                        <span class="font-bold text-white text-sm print:text-black">{{ $registration->full_name }}</span>
                    </div>

                    <div class="bg-white/[0.03] p-4 rounded-xl border border-white/10 print:border-gray-300 print:bg-gray-50">
                        <span class="text-slate-400 block text-[11px] font-medium mb-1 print:text-gray-500">Nomor Registrasi:</span>
                        <span class="font-mono font-bold text-[#F3E5AB] text-sm print:text-black">{{ $registration->registration_code }}</span>
                    </div>

                    <div class="bg-white/[0.03] p-4 rounded-xl border border-white/10 print:border-gray-300 print:bg-gray-50">
                        <span class="text-slate-400 block text-[11px] font-medium mb-1 print:text-gray-500">Instansi / Perusahaan:</span>
                        <span class="font-semibold text-white text-sm print:text-black">{{ $registration->company_name }}</span>
                    </div>

                    <div class="bg-white/[0.03] p-4 rounded-xl border border-white/10 print:border-gray-300 print:bg-gray-50">
                        <span class="text-slate-400 block text-[11px] font-medium mb-1 print:text-gray-500">Jabatan / Posisi:</span>
                        <span class="font-semibold text-white text-sm print:text-black">{{ $registration->position }}</span>
                    </div>

                    <div class="bg-white/[0.03] p-4 rounded-xl border border-white/10 print:border-gray-300 print:bg-gray-50 sm:col-span-2 flex items-center justify-between">
                        <div>
                            <span class="text-slate-400 block text-[11px] font-medium mb-0.5 print:text-gray-500">Kategori Partisipasi:</span>
                            <span class="font-bold uppercase tracking-wider text-[#D4AF37] print:text-black text-sm">{{ $registration->participation_category }}</span>
                        </div>
                        <span class="material-symbols-outlined text-2xl text-[#D4AF37]/60 print:hidden">workspace_premium</span>
                    </div>
                </div>

                <!-- Event Schedule & Location Notice -->
                <div class="p-4 sm:p-5 rounded-xl bg-white/[0.02] border border-white/10 text-xs text-slate-300 space-y-2 print:border-gray-300 print:bg-gray-50 print:text-black">
                    <div class="font-semibold text-white flex items-center gap-2 print:text-black">
                        <span class="material-symbols-outlined text-[#D4AF37] text-base print:hidden">event_available</span>
                        <span>Informasi Kehadiran di Tempat:</span>
                    </div>
                    <p class="leading-relaxed text-[11px] text-slate-300 print:text-gray-700">
                        <strong>Jadwal:</strong> {{ config('event.dates') }} ({{ config('event.time_schedule') }})<br>
                        <strong>Venue:</strong> {{ config('event.venue_name') }} — {{ config('event.venue_address') }}
                    </p>
                    <p class="text-[10px] text-slate-400 leading-relaxed print:text-gray-500 pt-1 border-t border-white/5">
                        * Harap menunjukkan e-Badge ini bersama identitas diri berfoto resmi (KTP/Paspor) saat check-in. Tiket ini tidak dapat dipindahtangankan.
                    </p>
                </div>
            </div>

            <!-- Card Actions -->
            <div class="p-6 bg-white/[0.02] border-t border-white/10 flex flex-col sm:flex-row items-center justify-between gap-3 print:hidden">
                <button 
                    type="button" 
                    onclick="window.print()" 
                    class="w-full sm:w-auto px-6 py-3 rounded-xl gold-gradient-btn text-black text-xs font-bold uppercase tracking-widest flex items-center justify-center gap-2 cursor-pointer shadow-lg hover:shadow-[#D4AF37]/20 transition-all"
                >
                    <span class="material-symbols-outlined text-base">print</span>
                    <span>Cetak / Simpan PDF</span>
                </button>
                <a 
                    href="{{ url('/') }}" 
                    class="w-full sm:w-auto px-5 py-3 rounded-xl bg-white/5 hover:bg-white/10 border border-white/15 hover:border-white/30 text-slate-200 text-xs font-medium uppercase tracking-wider flex items-center justify-center gap-2 transition-all"
                >
                    <span class="material-symbols-outlined text-base">arrow_back</span>
                    <span>Kembali ke Beranda</span>
                </a>
            </div>

        </div>

        <div class="text-center mt-6 text-xs text-slate-500 font-medium print:hidden">
            {{ config('event.organizer') }} &bull; Layanan Terpadu Konferensi KEK
        </div>

    </div>
</div>
@endsection
