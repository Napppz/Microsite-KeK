@extends('layouts.app')

@section('title', 'Formulir Registrasi Peserta & Delegasi — ' . config('event.name') . ' ' . config('event.year'))

@section('content')
<div class="w-full bg-[#060A10] text-white py-10 px-4 sm:px-6 lg:px-12 relative overflow-hidden min-h-screen">
    <!-- Ambient Background Lighting Orbs -->
    <div class="absolute top-20 right-10 w-[600px] h-[600px] bg-amber-500/10 rounded-full blur-[160px] pointer-events-none -z-10"></div>
    <div class="absolute bottom-20 left-10 w-[500px] h-[500px] bg-blue-600/10 rounded-full blur-[150px] pointer-events-none -z-10"></div>

    <div class="max-w-[1360px] mx-auto space-y-10">
        <!-- Top Executive Header Banner -->
        <div class="glass-panel p-8 sm:p-12 rounded-3xl border border-white/15 shadow-2xl relative overflow-hidden backdrop-blur-2xl">
            <!-- Subtle Top Gold Glow Strip -->
            <div class="absolute top-0 inset-x-0 h-1 bg-gradient-to-r from-transparent via-amber-400 to-transparent"></div>

            <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-8">
                <div class="space-y-4 max-w-3xl">
                    <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full glass-panel border border-amber-500/30 text-amber-400 text-xs font-bold uppercase tracking-wider">
                        <span class="material-symbols-outlined text-sm">verified</span>
                        <span>Akreditasi Delegasi Resmi Negara</span>
                    </div>
                    <h1 class="font-serif text-3xl sm:text-4xl lg:text-5xl font-extrabold tracking-tight text-white leading-tight">
                        Formulir Registrasi Peserta &amp; Delegasi {{ config('event.year') }}
                    </h1>
                    <p class="text-sm sm:text-base text-slate-300 leading-relaxed max-w-2xl font-normal">
                        Pendaftaran resmi pertemuan bilateral, eksplorasi peluang hilirisasi industri strategis, dan penerbitan tanda pengenal digital resmi {{ config('event.name') }} {{ config('event.year') }}.
                    </p>
                </div>
                <div class="glass-panel p-5 rounded-2xl border border-white/15 flex items-center gap-4 self-start lg:self-end">
                    <div class="w-12 h-12 rounded-xl gold-gradient-btn flex items-center justify-center text-[#060A10] font-bold shadow-md shadow-amber-500/20">
                        <span class="material-symbols-outlined text-2xl">event_available</span>
                    </div>
                    <div>
                        <div class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Batas Akhir Akreditasi</div>
                        <div class="font-serif text-base sm:text-lg text-white font-bold">{{ config('event.dates') }}</div>
                        <div class="text-xs text-amber-400 font-medium">Sistem Terpadu OSS KEK</div>
                    </div>
                </div>
            </div>
        </div>

        @if ($errors->any())
            <div class="p-5 glass-panel border border-red-500/50 rounded-2xl text-red-200 text-sm flex items-start gap-4 shadow-xl">
                <div class="w-9 h-9 rounded-xl bg-red-500/20 border border-red-500/30 flex items-center justify-center text-red-400 flex-shrink-0">
                    <span class="material-symbols-outlined text-xl">error</span>
                </div>
                <div>
                    <div class="font-bold text-white text-base">Mohon periksa kembali isian formulir:</div>
                    <ul class="list-disc list-inside mt-2 space-y-1 text-xs text-red-300">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-start">
            <!-- Registration Form Column -->
            <div class="lg:col-span-8 glass-panel p-8 sm:p-10 rounded-3xl border border-white/15 shadow-2xl relative backdrop-blur-2xl">
                <div class="flex items-center justify-between pb-6 border-b border-white/10 mb-8">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-amber-500/10 border border-amber-500/30 flex items-center justify-center text-amber-400">
                            <span class="material-symbols-outlined text-xl">badge</span>
                        </div>
                        <span class="text-sm font-bold tracking-wider uppercase text-white font-serif">
                            Dokumen Akreditasi &amp; Tanda Masuk Resmi
                        </span>
                    </div>
                    <span class="text-xs px-3 py-1 rounded-full bg-amber-500/20 border border-amber-500/30 text-amber-300 uppercase font-bold tracking-wider">
                        Tahap 1 / 1
                    </span>
                </div>

                <div class="space-y-8">
                    <div class="glass-panel p-4 rounded-xl border border-white/10 flex items-start gap-3 bg-white/5">
                        <span class="material-symbols-outlined text-amber-400 text-xl mt-0.5">info</span>
                        <div class="space-y-1">
                            <span class="text-xs font-bold uppercase tracking-wider text-white">Instruksi Pengisian Data Delegasi</span>
                            <p class="text-xs text-slate-300 leading-relaxed font-normal">
                                Pendaftaran wajib diisi dengan identitas valid instansi/perusahaan untuk keperluan verifikasi keamanan, pencetakan ID Badge fisik, dan penerbitan tanda pengenal digital resmi KEK.
                            </p>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('registration.store') }}" class="space-y-8" id="delegation-form">
                        @csrf

                        <!-- Section 1: Data Diri Delegasi -->
                        <div class="space-y-4">
                            <div class="flex items-center gap-3 pb-3 border-b border-white/10">
                                <div class="w-7 h-7 rounded-lg bg-amber-500/20 border border-amber-500/40 text-amber-400 flex items-center justify-center text-xs font-bold">1</div>
                                <h2 class="text-sm font-bold uppercase tracking-wider text-white">Data Diri Delegasi</h2>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                <div>
                                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-2" for="full_name">
                                        Nama Lengkap (dengan Gelar) <span class="text-amber-400">*</span>
                                    </label>
                                    <input 
                                        id="full_name"
                                        name="full_name"
                                        value="{{ old('full_name', request('full_name')) }}"
                                        class="w-full bg-white/5 border {{ $errors->has('full_name') ? 'border-red-500 ring-1 ring-red-500' : 'border-white/15' }} px-4 py-3 text-sm text-white placeholder-slate-500 focus:outline-none focus:border-amber-400 focus:ring-1 focus:ring-amber-400 rounded-xl transition-all font-medium" 
                                        placeholder="Contoh: Dr. Ir. Budi Santoso, M.B.A." 
                                        required 
                                        type="text"
                                    />
                                    @error('full_name')
                                        <p class="text-xs text-red-400 mt-1.5">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-2" for="email">
                                        Alamat Email Resmi / Korporat <span class="text-amber-400">*</span>
                                    </label>
                                    <input 
                                        id="email"
                                        name="email"
                                        value="{{ old('email', request('email')) }}"
                                        class="w-full bg-white/5 border {{ $errors->has('email') ? 'border-red-500 ring-1 ring-red-500' : 'border-white/15' }} px-4 py-3 text-sm text-white placeholder-slate-500 focus:outline-none focus:border-amber-400 focus:ring-1 focus:ring-amber-400 rounded-xl transition-all font-medium" 
                                        placeholder="nama@perusahaan.co.id" 
                                        required 
                                        type="email"
                                    />
                                    @error('email')
                                        <p class="text-xs text-red-400 mt-1.5">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-2" for="phone_number">
                                        Nomor Telepon / WhatsApp Aktif <span class="text-amber-400">*</span>
                                    </label>
                                    <input 
                                        id="phone_number"
                                        name="phone_number"
                                        value="{{ old('phone_number') }}"
                                        class="w-full bg-white/5 border {{ $errors->has('phone_number') ? 'border-red-500 ring-1 ring-red-500' : 'border-white/15' }} px-4 py-3 text-sm text-white placeholder-slate-500 focus:outline-none focus:border-amber-400 focus:ring-1 focus:ring-amber-400 rounded-xl transition-all font-medium" 
                                        placeholder="+62 812-3456-7890" 
                                        required 
                                        type="tel"
                                    />
                                    @error('phone_number')
                                        <p class="text-xs text-red-400 mt-1.5">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-2" for="position">
                                        Jabatan / Posisi dalam Instansi <span class="text-amber-400">*</span>
                                    </label>
                                    <input 
                                        id="position"
                                        name="position"
                                        value="{{ old('position') }}"
                                        class="w-full bg-white/5 border {{ $errors->has('position') ? 'border-red-500 ring-1 ring-red-500' : 'border-white/15' }} px-4 py-3 text-sm text-white placeholder-slate-500 focus:outline-none focus:border-amber-400 focus:ring-1 focus:ring-amber-400 rounded-xl transition-all font-medium" 
                                        placeholder="Chief Investment Officer / Direktur Utama" 
                                        required 
                                        type="text"
                                    />
                                    @error('position')
                                        <p class="text-xs text-red-400 mt-1.5">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Section 2: Informasi Organisasi & Entitas -->
                        <div class="space-y-4">
                            <div class="flex items-center gap-3 pb-3 border-b border-white/10">
                                <div class="w-7 h-7 rounded-lg bg-amber-500/20 border border-amber-500/40 text-amber-400 flex items-center justify-center text-xs font-bold">2</div>
                                <h2 class="text-sm font-bold uppercase tracking-wider text-white">Informasi Organisasi &amp; Entitas</h2>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                <div class="md:col-span-2">
                                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-2" for="company_name">
                                        Nama Perusahaan / Instansi / Kedutaan <span class="text-amber-400">*</span>
                                    </label>
                                    <input 
                                        id="company_name"
                                        name="company_name"
                                        value="{{ old('company_name', request('company_name')) }}"
                                        class="w-full bg-white/5 border {{ $errors->has('company_name') ? 'border-red-500 ring-1 ring-red-500' : 'border-white/15' }} px-4 py-3 text-sm text-white placeholder-slate-500 focus:outline-none focus:border-amber-400 focus:ring-1 focus:ring-amber-400 rounded-xl transition-all font-medium" 
                                        placeholder="PT Mandiri Nusantara Infrastruktur / Kedutaan Besar" 
                                        required 
                                        type="text"
                                    />
                                    @error('company_name')
                                        <p class="text-xs text-red-400 mt-1.5">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-2" for="organization_type">
                                        Jenis Organisasi <span class="text-amber-400">*</span>
                                    </label>
                                    <select 
                                        id="organization_type" 
                                        name="organization_type" 
                                        class="w-full bg-[#0D1524] border {{ $errors->has('organization_type') ? 'border-red-500' : 'border-white/15' }} px-4 py-3 text-sm text-white focus:outline-none focus:border-amber-400 focus:ring-1 focus:ring-amber-400 rounded-xl"
                                        required
                                    >
                                        <option value="" disabled {{ old('organization_type') ? '' : 'selected' }}>Pilih Klasifikasi Lembaga</option>
                                        <option value="swasta" {{ old('organization_type') == 'swasta' ? 'selected' : '' }}>Badan Usaha Swasta Nasional</option>
                                        <option value="fdi" {{ old('organization_type') == 'fdi' ? 'selected' : '' }}>Perusahaan Multinasional / FDI</option>
                                        <option value="pemerintah" {{ old('organization_type') == 'pemerintah' ? 'selected' : '' }}>Kementerian / Lembaga Pemerintah RI</option>
                                        <option value="kadin" {{ old('organization_type') == 'kadin' ? 'selected' : '' }}>Asosiasi Bisnis &amp; KADIN</option>
                                        <option value="kedutaan" {{ old('organization_type') == 'kedutaan' ? 'selected' : '' }}>Kedutaan Besar / Perwakilan Diplomatik</option>
                                        <option value="pengelola-kek" {{ old('organization_type') == 'pengelola-kek' ? 'selected' : '' }}>Badan Usaha Pembangun &amp; Pengelola KEK</option>
                                        <option value="bumn" {{ old('organization_type') == 'bumn' ? 'selected' : '' }}>BUMN / BUMD</option>
                                        <option value="lainnya" {{ old('organization_type') == 'lainnya' ? 'selected' : '' }}>Lembaga / Organisasi Lainnya</option>
                                    </select>
                                    @error('organization_type')
                                        <p class="text-xs text-red-400 mt-1.5">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-2" for="country">
                                        Negara Domisili Lembaga <span class="text-amber-400">*</span>
                                    </label>
                                    <select 
                                        id="country" 
                                        name="country" 
                                        class="w-full bg-[#0D1524] border {{ $errors->has('country') ? 'border-red-500' : 'border-white/15' }} px-4 py-3 text-sm text-white focus:outline-none focus:border-amber-400 focus:ring-1 focus:ring-amber-400 rounded-xl"
                                        required
                                    >
                                        <option value="ID" {{ old('country', 'ID') == 'ID' ? 'selected' : '' }}>Indonesia</option>
                                        <option value="SG" {{ old('country') == 'SG' ? 'selected' : '' }}>Singapura</option>
                                        <option value="JP" {{ old('country') == 'JP' ? 'selected' : '' }}>Jepang</option>
                                        <option value="CN" {{ old('country') == 'CN' ? 'selected' : '' }}>Republik Rakyat Tiongkok</option>
                                        <option value="KR" {{ old('country') == 'KR' ? 'selected' : '' }}>Korea Selatan</option>
                                        <option value="US" {{ old('country') == 'US' ? 'selected' : '' }}>Amerika Serikat</option>
                                        <option value="DE" {{ old('country') == 'DE' ? 'selected' : '' }}>Jerman</option>
                                        <option value="AE" {{ old('country') == 'AE' ? 'selected' : '' }}>Uni Emirat Arab</option>
                                        <option value="OTHER" {{ old('country') == 'OTHER' ? 'selected' : '' }}>Negara Lainnya...</option>
                                    </select>
                                    @error('country')
                                        <p class="text-xs text-red-400 mt-1.5">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="md:col-span-2">
                                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-2" for="city">
                                        Kota Kantor Pusat / Domisili <span class="text-amber-400">*</span>
                                    </label>
                                    <input 
                                        id="city"
                                        name="city"
                                        value="{{ old('city') }}"
                                        class="w-full bg-white/5 border {{ $errors->has('city') ? 'border-red-500 ring-1 ring-red-500' : 'border-white/15' }} px-4 py-3 text-sm text-white placeholder-slate-500 focus:outline-none focus:border-amber-400 focus:ring-1 focus:ring-amber-400 rounded-xl transition-all font-medium" 
                                        placeholder="Jakarta Selatan, Tokyo, Singapore, dll." 
                                        required 
                                        type="text"
                                    />
                                    @error('city')
                                        <p class="text-xs text-red-400 mt-1.5">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Section 3: Kategori Partisipasi & Sektor KEK -->
                        <div class="space-y-4">
                            <div class="flex items-center gap-3 pb-3 border-b border-white/10">
                                <div class="w-7 h-7 rounded-lg bg-amber-500/20 border border-amber-500/40 text-amber-400 flex items-center justify-center text-xs font-bold">3</div>
                                <h2 class="text-sm font-bold uppercase tracking-wider text-white">Kategori Partisipasi &amp; Sektor KEK</h2>
                            </div>
                            <div class="space-y-3">
                                <span class="block text-xs font-bold uppercase tracking-wider text-slate-300">
                                    Kategori Delegasi <span class="text-amber-400">*</span>
                                </span>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                                    <label class="flex items-center gap-3.5 p-4 rounded-xl glass-panel border border-white/10 cursor-pointer hover:border-amber-400/40 transition-all">
                                        <input type="radio" name="participation_category" value="investor" {{ old('participation_category', 'investor') == 'investor' ? 'checked' : '' }} class="accent-[#F59E0B] w-4 h-4" />
                                        <div class="flex flex-col">
                                            <span class="text-xs font-bold text-white">Delegasi Bisnis / Investor</span>
                                            <span class="text-[11px] text-slate-400 font-normal">Calon penanam modal KEK &amp; mitra industri</span>
                                        </div>
                                    </label>
                                    <label class="flex items-center gap-3.5 p-4 rounded-xl glass-panel border border-white/10 cursor-pointer hover:border-amber-400/40 transition-all">
                                        <input type="radio" name="participation_category" value="speaker" {{ old('participation_category') == 'speaker' ? 'checked' : '' }} class="accent-[#F59E0B] w-4 h-4" />
                                        <div class="flex flex-col">
                                            <span class="text-xs font-bold text-white">Narasumber / Panelis</span>
                                            <span class="text-[11px] text-slate-400 font-normal">Pemateri resmi sesi pleno &amp; panel</span>
                                        </div>
                                    </label>
                                    <label class="flex items-center gap-3.5 p-4 rounded-xl glass-panel border border-white/10 cursor-pointer hover:border-amber-400/40 transition-all">
                                        <input type="radio" name="participation_category" value="vvip" {{ old('participation_category') == 'vvip' ? 'checked' : '' }} class="accent-[#F59E0B] w-4 h-4" />
                                        <div class="flex flex-col">
                                            <span class="text-xs font-bold text-white">Undangan Khusus VVIP</span>
                                            <span class="text-[11px] text-slate-400 font-normal">Menteri, Dubes, &amp; Pimpinan Lembaga Tinggi</span>
                                        </div>
                                    </label>
                                    <label class="flex items-center gap-3.5 p-4 rounded-xl glass-panel border border-white/10 cursor-pointer hover:border-amber-400/40 transition-all">
                                        <input type="radio" name="participation_category" value="media" {{ old('participation_category') == 'media' ? 'checked' : '' }} class="accent-[#F59E0B] w-4 h-4" />
                                        <div class="flex flex-col">
                                            <span class="text-xs font-bold text-white">Media / Pers Terakreditasi</span>
                                            <span class="text-[11px] text-slate-400 font-normal">Jurnalis resmi peliputan forum</span>
                                        </div>
                                    </label>
                                </div>
                            </div>

                            <div class="space-y-3 pt-2">
                                <span class="block text-xs font-bold uppercase tracking-wider text-slate-300">
                                    Minat Sektor Investasi KEK (Dapat memilih lebih dari satu)
                                </span>
                                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3">
                                    @php
                                        $selectedSectors = old('sectors', ['nikel', 'datacenter']);
                                    @endphp
                                    <label class="flex items-center gap-2.5 p-3 rounded-xl glass-panel border border-white/10 text-xs text-slate-300 cursor-pointer hover:border-amber-400/30 transition-all">
                                        <input type="checkbox" name="sectors[]" value="nikel" {{ in_array('nikel', $selectedSectors) ? 'checked' : '' }} class="accent-[#F59E0B]" />
                                        <span>Hilirisasi Nikel &amp; Mineral</span>
                                    </label>
                                    <label class="flex items-center gap-2.5 p-3 rounded-xl glass-panel border border-white/10 text-xs text-slate-300 cursor-pointer hover:border-amber-400/30 transition-all">
                                        <input type="checkbox" name="sectors[]" value="pariwisata" {{ in_array('pariwisata', $selectedSectors) ? 'checked' : '' }} class="accent-[#F59E0B]" />
                                        <span>Pariwisata &amp; Kreatif</span>
                                    </label>
                                    <label class="flex items-center gap-2.5 p-3 rounded-xl glass-panel border border-white/10 text-xs text-slate-300 cursor-pointer hover:border-amber-400/30 transition-all">
                                        <input type="checkbox" name="sectors[]" value="datacenter" {{ in_array('datacenter', $selectedSectors) ? 'checked' : '' }} class="accent-[#F59E0B]" />
                                        <span>Data Center &amp; AI Digital</span>
                                    </label>
                                    <label class="flex items-center gap-2.5 p-3 rounded-xl glass-panel border border-white/10 text-xs text-slate-300 cursor-pointer hover:border-amber-400/30 transition-all">
                                        <input type="checkbox" name="sectors[]" value="logistik" {{ in_array('logistik', $selectedSectors) ? 'checked' : '' }} class="accent-[#F59E0B]" />
                                        <span>Logistik Maritim &amp; Pelabuhan</span>
                                    </label>
                                    <label class="flex items-center gap-2.5 p-3 rounded-xl glass-panel border border-white/10 text-xs text-slate-300 cursor-pointer hover:border-amber-400/30 transition-all">
                                        <input type="checkbox" name="sectors[]" value="farmasi" {{ in_array('farmasi', $selectedSectors) ? 'checked' : '' }} class="accent-[#F59E0B]" />
                                        <span>Farmasi &amp; Pusat Medis</span>
                                    </label>
                                    <label class="flex items-center gap-2.5 p-3 rounded-xl glass-panel border border-white/10 text-xs text-slate-300 cursor-pointer hover:border-amber-400/30 transition-all">
                                        <input type="checkbox" name="sectors[]" value="energi" {{ in_array('energi', $selectedSectors) ? 'checked' : '' }} class="accent-[#F59E0B]" />
                                        <span>Energi Terbarukan (EBT)</span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Section 4: Sesi yang Hendak Diikuti -->
                        <div class="space-y-4">
                            <div class="flex items-center gap-3 pb-3 border-b border-white/10">
                                <div class="w-7 h-7 rounded-lg bg-amber-500/20 border border-amber-500/40 text-amber-400 flex items-center justify-center text-xs font-bold">4</div>
                                <h2 class="text-sm font-bold uppercase tracking-wider text-white">Sesi yang Hendak Diikuti</h2>
                            </div>
                            <div class="space-y-3">
                                <div class="p-4 rounded-xl glass-panel border border-white/10 flex items-start gap-3.5">
                                    <input type="checkbox" checked disabled class="mt-1 accent-[#F59E0B] cursor-not-allowed w-4 h-4" />
                                    <input type="hidden" name="sessions[]" value="plenary" />
                                    <div>
                                        <div class="text-xs font-bold text-white flex items-center gap-2">
                                            <span>Plenary Session Utama (Hari Ke-1)</span>
                                            <span class="text-[10px] px-2.5 py-0.5 rounded-full bg-blue-500/20 text-blue-300 uppercase font-bold tracking-wider">Wajib / Otomatis</span>
                                        </div>
                                        <p class="text-xs text-slate-400 mt-1 leading-relaxed font-normal">
                                            Pidato Kunci Presiden RI / Menko Perekonomian, Pemaparan Insentif Fiskal KEK, dan Penandatanganan MoU Investasi Strategis.
                                        </p>
                                    </div>
                                </div>
                                <div class="p-4 rounded-xl glass-panel border border-white/10 flex items-start gap-3.5 hover:border-amber-400/30 transition-all">
                                    <input 
                                        type="checkbox" 
                                        id="session_b2b" 
                                        name="sessions[]" 
                                        value="b2b" 
                                        {{ in_array('b2b', old('sessions', ['b2b'])) ? 'checked' : '' }}
                                        class="mt-1 accent-[#F59E0B] w-4 h-4 cursor-pointer" 
                                    />
                                    <label for="session_b2b" class="cursor-pointer">
                                        <div class="text-xs font-bold text-white flex items-center gap-2">
                                            <span>Bilateral Matchmaking &amp; One-on-One Investment Room (Hari Ke-2)</span>
                                            <span class="text-[10px] px-2.5 py-0.5 rounded-full bg-amber-500/20 text-amber-300 uppercase font-bold tracking-wider">Eksklusif</span>
                                        </div>
                                        <p class="text-xs text-slate-400 mt-1 leading-relaxed font-normal">
                                            Pertemuan tertutup dengan administrator kawasan KEK terpilih dan lembaga pembiayaan perbankan multilateral.
                                        </p>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Section 5: Catatan Protokoler & Persetujuan -->
                        <div class="space-y-4">
                            <div class="flex items-center gap-3 pb-3 border-b border-white/10">
                                <div class="w-7 h-7 rounded-lg bg-amber-500/20 border border-amber-500/40 text-amber-400 flex items-center justify-center text-xs font-bold">5</div>
                                <h2 class="text-sm font-bold uppercase tracking-wider text-white">Catatan Protokoler &amp; Persetujuan</h2>
                            </div>
                            <div>
                                <label class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-2" for="special_notes">
                                    Catatan Khusus Protokoler / Kebutuhan Aksesibilitas (Opsional)
                                </label>
                                <textarea 
                                    id="special_notes" 
                                    name="special_notes" 
                                    rows="3" 
                                    class="w-full bg-white/5 border border-white/15 px-4 py-3 text-sm text-white placeholder-slate-500 focus:outline-none focus:border-amber-400 focus:ring-1 focus:ring-amber-400 rounded-xl transition-all font-medium"
                                    placeholder="Contoh: Pengawalan resmi, kebutuhan penerjemah bahasa khusus, atau permintaan meja bilateral khusus..."
                                >{{ old('special_notes') }}</textarea>
                            </div>

                            <div class="p-4 rounded-xl glass-panel border {{ $errors->has('privacy_agreed') ? 'border-red-500 ring-1 ring-red-500' : 'border-white/10' }}">
                                <label class="flex items-start gap-3 cursor-pointer">
                                    <input 
                                        type="checkbox" 
                                        id="privacy_agreed" 
                                        name="privacy_agreed" 
                                        value="1" 
                                        {{ old('privacy_agreed') ? 'checked' : '' }}
                                        class="mt-1 accent-[#F59E0B] w-4 h-4 cursor-pointer" 
                                        required
                                    />
                                    <div class="text-xs text-slate-300 leading-relaxed font-normal">
                                        Saya menyatakan bahwa data yang diisikan adalah benar dan sah mewakili instansi terkait. Saya menyetujui pemrosesan data pribadi untuk keperluan akreditasi, verifikasi keamanan kedatangan, dan penerbitan tiket digital sesuai ketentuan <strong>Undang-Undang Perlindungan Data Pribadi</strong> (UU PDP No. 27/2022) Republik Indonesia. <span class="text-amber-400 font-bold">*</span>
                                    </div>
                                </label>
                                @error('privacy_agreed')
                                    <p class="text-xs text-red-400 mt-2">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="pt-6 flex flex-col sm:flex-row items-center justify-between gap-4 border-t border-white/10">
                            <a href="{{ url('/') }}" class="text-xs text-slate-400 hover:text-white flex items-center gap-1.5 transition-colors font-medium">
                                <span class="material-symbols-outlined text-base">arrow_back</span>
                                <span>Kembali ke Beranda Acara</span>
                            </a>
                            <button 
                                type="submit" 
                                id="submit-registration-btn"
                                class="w-full sm:w-auto px-8 py-4 rounded-xl gold-gradient-btn text-xs font-bold uppercase tracking-wider flex items-center justify-center gap-2 shadow-xl shadow-amber-500/25 hover:shadow-amber-500/40 transition-all cursor-pointer"
                            >
                                <span>Kirim Permohonan Akreditasi</span>
                                <span class="material-symbols-outlined text-base">arrow_forward</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Sidebar Information Column -->
            <div class="lg:col-span-4 space-y-6">
                <!-- Policy & Verification Card -->
                <div class="glass-panel p-7 rounded-3xl border border-white/15 shadow-xl space-y-5">
                    <div class="flex items-center gap-2 text-amber-400">
                        <span class="material-symbols-outlined text-xl">policy</span>
                        <span class="text-xs font-bold uppercase tracking-wider text-white">Prosedur Akreditasi</span>
                    </div>
                    <div class="space-y-4 pt-1">
                        <div class="flex items-start gap-3.5">
                            <div class="w-7 h-7 rounded-xl bg-amber-500/10 border border-amber-500/30 text-amber-400 font-bold flex items-center justify-center text-xs flex-shrink-0">
                                01
                            </div>
                            <div>
                                <div class="text-xs font-bold text-white">Skrining Validitas 1x24 Jam</div>
                                <p class="text-xs text-slate-400 leading-relaxed mt-0.5 font-normal">
                                    Sekretariat Dewan Nasional KEK memverifikasi identitas korporat dan delegasi resmi sesuai kuota negara/instansi.
                                </p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3.5">
                            <div class="w-7 h-7 rounded-xl bg-amber-500/10 border border-amber-500/30 text-amber-400 font-bold flex items-center justify-center text-xs flex-shrink-0">
                                02
                            </div>
                            <div>
                                <div class="text-xs font-bold text-white">Penerbitan QR Credential</div>
                                <p class="text-xs text-slate-400 leading-relaxed mt-0.5 font-normal">
                                    Delegasi yang lolos seleksi menerima surat konfirmasi resmi dan e-Badge QR terenkripsi via email.
                                </p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3.5">
                            <div class="w-7 h-7 rounded-xl bg-amber-500/10 border border-amber-500/30 text-amber-400 font-bold flex items-center justify-center text-xs flex-shrink-0">
                                03
                            </div>
                            <div>
                                <div class="text-xs font-bold text-white">Bebas Biaya Partisipasi</div>
                                <p class="text-xs text-slate-400 leading-relaxed mt-0.5 font-normal">
                                    Forum berskala nasional ini diselenggarakan secara gratis untuk delegasi yang telah terakreditasi oleh dewan penyelenggara.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Secretariat Support Card -->
                <div class="glass-panel p-7 rounded-3xl border border-white/15 shadow-xl space-y-4">
                    <div class="text-xs font-bold uppercase tracking-wider text-white flex items-center gap-2">
                        <span class="material-symbols-outlined text-amber-400 text-lg">contact_support</span>
                        <span>Sekretariat Registrasi</span>
                    </div>
                    <p class="text-xs text-slate-300 leading-relaxed font-normal">
                        Memerlukan surat undangan formal (Letter of Invitation) untuk pengurusan visa diplomatik atau kebutuhan birokrasi?
                    </p>
                    <div class="pt-3 space-y-2.5 border-t border-white/10 text-xs text-slate-300 font-medium">
                        <div class="flex items-center gap-2.5">
                            <span class="material-symbols-outlined text-amber-400 text-base">mail</span>
                            <span>registrasi@kek.go.id</span>
                        </div>
                        <div class="flex items-center gap-2.5">
                            <span class="material-symbols-outlined text-amber-400 text-base">phone_in_talk</span>
                            <span>+62 21 352 1971 (Ext. 204)</span>
                        </div>
                        <div class="flex items-center gap-2.5">
                            <span class="material-symbols-outlined text-amber-400 text-base">schedule</span>
                            <span>Senin - Jumat (08:30 - 17:00 WIB)</span>
                        </div>
                    </div>
                </div>

                <!-- Quota Status Banner -->
                <div class="glass-panel p-6 rounded-3xl border border-amber-500/30 shadow-xl space-y-3 bg-gradient-to-br from-amber-500/10 via-transparent to-transparent">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold uppercase tracking-wider text-white">Status Kuota Delegasi</span>
                        <span class="text-[11px] px-3 py-0.5 rounded-full gold-gradient-btn font-bold">Tersisa 18%</span>
                    </div>
                    <div class="w-full bg-white/10 h-2.5 rounded-full overflow-hidden p-0.5">
                        <div class="bg-gradient-to-r from-amber-400 to-amber-600 h-full w-[82%] rounded-full shadow-sm shadow-amber-500"></div>
                    </div>
                    <p class="text-xs text-slate-400 pt-1 font-normal">
                        Kapasitas plenary auditorium utama: 1.200 delegasi internasional &amp; domestik.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
