@extends('layouts.app')

@section('title', 'Pemindai Kehadiran Staf — ' . config('event.name'))

@section('content')
<div class="w-full bg-[#060A10] text-white py-8 sm:py-12 px-4 sm:px-6 lg:px-8 min-h-[90vh] relative overflow-hidden">
    <!-- Ambient Radial Lighting -->
    <div class="absolute top-10 left-1/2 -translate-x-1/2 w-[700px] h-[500px] bg-gradient-to-b from-[#D4AF37]/10 to-transparent rounded-full blur-[150px] pointer-events-none -z-10"></div>
    <div class="absolute bottom-10 right-10 w-96 h-96 bg-[#183B5B]/20 rounded-full blur-[130px] pointer-events-none -z-10"></div>

    <div class="max-w-[760px] mx-auto space-y-6">

        <!-- Top Header & Event Context Bar -->
        <div class="glass-panel border border-white/15 p-5 sm:p-6 rounded-2xl flex flex-col sm:flex-row items-center justify-between gap-4 shadow-xl">
            <div class="flex items-center gap-3.5">
                <img src="{{ asset('images/kek/logo-kek-white.png') }}" alt="Dewan Nasional KEK" class="h-8 sm:h-9 w-auto object-contain hidden sm:block">
                <div class="h-8 w-px bg-white/20 hidden sm:block"></div>
                <div>
                    <div class="text-[10px] uppercase tracking-[0.25em] text-[#D4AF37] font-semibold">
                        Meja Registrasi & Akreditasi
                    </div>
                    <h1 class="font-display text-xl sm:text-2xl font-bold text-white tracking-tight">
                        {{ config('event.name') }} {{ $event->year }}
                    </h1>
                </div>
            </div>

            <!-- Staff Navigation & Identity -->
            <div class="flex items-center gap-2.5 self-end sm:self-center flex-wrap justify-end">
                <a 
                    href="{{ route('staff.dashboard') }}" 
                    class="px-4 py-2 rounded-xl bg-white/5 hover:bg-white/10 border border-white/15 hover:border-white/30 text-white text-xs font-semibold tracking-wider flex items-center gap-2 transition-all"
                >
                    <span class="material-symbols-outlined text-base text-[#D4AF37]">analytics</span>
                    <span>Dashboard &amp; Laporan</span>
                </a>
                <div class="text-right text-xs pl-3 border-l border-white/10 hidden md:block">
                    <span class="font-semibold text-white block">{{ $staffUser->name }}</span>
                    <span class="text-[10px] text-slate-400 font-mono uppercase tracking-wider">{{ strtoupper($staffUser->role) }}</span>
                </div>
                <form method="POST" action="{{ route('staff.logout') }}">
                    @csrf
                    <button 
                        type="submit" 
                        title="Keluar dari sesi staf"
                        class="px-3.5 py-2 rounded-xl border border-white/15 hover:border-rose-400/50 hover:bg-rose-500/10 text-slate-300 hover:text-rose-300 text-xs flex items-center gap-1.5 transition-all cursor-pointer"
                    >
                        <span class="material-symbols-outlined text-base">logout</span>
                        <span class="hidden sm:inline">Keluar</span>
                    </button>
                </form>
            </div>
        </div>

        <!-- Attendance Stats Counters -->
        <div class="grid grid-cols-2 gap-4">
            <div class="glass-panel border border-white/10 p-5 rounded-2xl text-center relative overflow-hidden">
                <div class="absolute top-0 left-0 right-0 h-1 bg-emerald-500"></div>
                <span class="text-[11px] uppercase tracking-wider text-slate-400 font-semibold block mb-1">Total Hadir (Check-in)</span>
                <span class="font-mono text-3xl sm:text-4xl font-extrabold text-emerald-400 drop-shadow-[0_0_15px_rgba(52,211,153,0.3)]" id="stat-total-checkins">
                    {{ $totalCheckedIn }}
                </span>
            </div>
            <div class="glass-panel border border-white/10 p-5 rounded-2xl text-center relative overflow-hidden">
                <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-[#D4AF37] to-[#F3E5AB]"></div>
                <span class="text-[11px] uppercase tracking-wider text-slate-400 font-semibold block mb-1">Total Delegasi Terdaftar</span>
                <span class="font-mono text-3xl sm:text-4xl font-extrabold text-[#F3E5AB] drop-shadow-[0_0_15px_rgba(212,175,55,0.3)]">
                    {{ $totalRegistrations }}
                </span>
            </div>
        </div>

        <!-- Main Scanner Box -->
        <div class="glass-panel border border-white/15 rounded-3xl overflow-hidden shadow-[0_20px_50px_rgba(0,0,0,0.6)] relative">
            <div class="h-1.5 bg-gradient-to-r from-[#D4AF37] via-[#F3E5AB] to-[#C59B27]"></div>

            <div class="p-5 sm:p-7 space-y-5">
                
                <!-- Camera Controls & Camera Selector -->
                <div class="flex flex-col sm:flex-row items-center justify-between gap-3 pb-4 border-b border-white/10">
                    <div class="flex items-center gap-2.5 w-full sm:w-auto">
                        <button 
                            type="button" 
                            id="btn-toggle-camera"
                            onclick="toggleCamera()"
                            class="flex-1 sm:flex-none px-5 py-2.5 rounded-xl gold-gradient-btn text-black text-xs font-bold uppercase tracking-wider flex items-center justify-center gap-2 transition-all cursor-pointer shadow-lg hover:shadow-[#D4AF37]/25"
                        >
                            <span class="material-symbols-outlined text-lg" id="camera-btn-icon">videocam</span>
                            <span id="camera-btn-label">Aktifkan Kamera</span>
                        </button>
                        <button 
                            type="button" 
                            id="btn-switch-camera"
                            onclick="switchCameraFacing()"
                            title="Ganti Kamera Depan/Belakang"
                            class="px-3.5 py-2.5 rounded-xl bg-white/5 hover:bg-white/10 border border-white/15 hover:border-white/30 text-white text-xs flex items-center justify-center transition-all cursor-pointer"
                        >
                            <span class="material-symbols-outlined text-lg">flip_camera_ios</span>
                        </button>
                    </div>

                    <div class="text-xs text-slate-300 flex items-center gap-2.5 self-start sm:self-center font-medium" id="scanner-status-indicator">
                        <span class="w-2.5 h-2.5 rounded-full bg-slate-500" id="status-dot"></span>
                        <span id="status-text">Kamera Siap</span>
                    </div>
                </div>

                <!-- Camera Viewport Container -->
                <div class="relative w-full aspect-square sm:aspect-[4/3] bg-black/90 rounded-2xl overflow-hidden flex items-center justify-center border border-white/15 shadow-inner" id="viewport-container">
                    
                    <!-- HTML5 QR Code Mount Element -->
                    <div id="qr-reader" class="w-full h-full"></div>

                    <!-- Overlay Placeholder when Camera is Off -->
                    <div id="camera-off-placeholder" class="absolute inset-0 flex flex-col items-center justify-center bg-[#060A10]/95 p-6 text-center space-y-3.5 z-10">
                        <div class="w-16 h-16 rounded-2xl bg-white/5 border border-white/10 flex items-center justify-center text-slate-400 shadow-lg">
                            <span class="material-symbols-outlined text-3xl">photo_camera</span>
                        </div>
                        <h2 class="text-base font-bold text-white tracking-tight">Pemindai QR Kamera Belum Aktif</h2>
                        <p class="text-xs text-slate-400 max-w-xs leading-relaxed font-normal">
                            Klik tombol <strong class="text-white">"Aktifkan Kamera"</strong> di atas untuk memulai pemindaian otomatis kartu delegasi peserta.
                        </p>
                    </div>

                    <!-- Scan Reticle / Laser Frame (Active during scanning) -->
                    <div id="scan-frame" class="absolute inset-8 sm:inset-12 border-2 border-white/10 rounded-2xl pointer-events-none hidden z-20 flex flex-col justify-between p-3">
                        <div class="flex justify-between">
                            <span class="w-7 h-7 border-t-4 border-l-4 border-[#D4AF37] rounded-tl-lg"></span>
                            <span class="w-7 h-7 border-t-4 border-r-4 border-[#D4AF37] rounded-tr-lg"></span>
                        </div>
                        <div class="text-center text-[10px] uppercase tracking-wider text-slate-200 bg-black/70 py-1.5 px-4 rounded-full mx-auto backdrop-blur-md border border-white/15">
                            Arahkan QR Code ke Dalam Kotak
                        </div>
                        <div class="flex justify-between">
                            <span class="w-7 h-7 border-b-4 border-l-4 border-[#D4AF37] rounded-bl-lg"></span>
                            <span class="w-7 h-7 border-b-4 border-r-4 border-[#D4AF37] rounded-br-lg"></span>
                        </div>
                    </div>

                    <!-- Verification In Progress Spinner Overlay -->
                    <div id="loading-overlay" class="absolute inset-0 bg-black/85 flex flex-col items-center justify-center space-y-3 hidden z-30 backdrop-blur-sm">
                        <div class="w-12 h-12 border-3 border-[#D4AF37] border-t-transparent rounded-full animate-spin"></div>
                        <span class="text-xs font-semibold uppercase tracking-widest text-white">Memverifikasi Tiket di Server...</span>
                    </div>

                </div>

                <!-- Dynamic Result Announcement Card -->
                <div id="result-card" class="hidden rounded-2xl p-5 border space-y-3 transition-all duration-300">
                    <!-- Populated by JavaScript -->
                </div>

            </div>
        </div>

        <!-- Manual Token Fallback Card -->
        <div class="glass-panel border border-white/15 p-5 sm:p-6 rounded-2xl space-y-3">
            <div class="flex items-center gap-2 text-xs font-semibold uppercase tracking-wider text-slate-200">
                <span class="material-symbols-outlined text-[#D4AF37] text-lg">keyboard</span>
                <span>Pencarian / Input Manual Token Tiket</span>
            </div>
            <p class="text-xs text-slate-400 font-normal">
                Gunakan jika kamera mengalami gangguan perangkat atau kode QR fisik mengalami kerusakan cetak.
            </p>
            <form id="manual-form" onsubmit="handleManualSubmit(event)" class="flex flex-col sm:flex-row gap-2.5 pt-1">
                <input 
                    type="text" 
                    id="manual-token-input" 
                    required 
                    placeholder="Tempel atau ketik kode token tiket..."
                    class="flex-1 px-4 py-3 bg-white/[0.04] border border-white/15 focus:border-[#D4AF37] focus:ring-2 focus:ring-[#D4AF37]/20 rounded-xl text-xs font-mono text-white placeholder-slate-500 outline-none transition-all"
                >
                <button 
                    type="submit" 
                    id="btn-manual-submit"
                    class="px-6 py-3 bg-white/10 hover:bg-white/20 border border-white/20 hover:border-white/40 text-white text-xs font-bold uppercase tracking-wider rounded-xl transition-all cursor-pointer whitespace-nowrap"
                >
                    Verifikasi Manual
                </button>
            </form>
        </div>

        <!-- Recent Check-ins Table -->
        <div class="glass-panel border border-white/15 p-5 sm:p-6 rounded-2xl space-y-4">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold uppercase tracking-wider text-white">
                    Riwayat Check-in Anda Sesi Ini
                </span>
                <span class="text-[11px] text-slate-400 font-medium">5 Terakhir</span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs" id="recent-checkins-table">
                    <thead>
                        <tr class="border-b border-white/10 text-slate-400 text-[10px] uppercase tracking-wider">
                            <th class="py-3 font-semibold">Delegasi</th>
                            <th class="py-3 font-semibold">Instansi</th>
                            <th class="py-3 font-semibold">Waktu</th>
                            <th class="py-3 font-semibold">Metode</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5 text-slate-300" id="recent-checkins-body">
                        @forelse($recentCheckIns as $recent)
                            <tr class="hover:bg-white/[0.02] transition-colors">
                                <td class="py-3 font-semibold text-white">{{ $recent->registration?->full_name }}</td>
                                <td class="py-3 text-slate-300">{{ $recent->registration?->company_name }}</td>
                                <td class="py-3 font-mono text-emerald-400">{{ $recent->checked_in_at->setTimezone('Asia/Jakarta')->format('H:i:s') }}</td>
                                <td class="py-3 text-[10px] uppercase text-slate-400 font-mono">{{ $recent->check_in_method }}</td>
                            </tr>
                        @empty
                            <tr id="no-recent-row">
                                <td colspan="4" class="py-6 text-center text-slate-500 text-xs">
                                    Belum ada check-in yang tercatat dalam sesi staf ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

<!-- Scanner Logic Script -->
<script>
    let html5QrCode = null;
    let isCameraActive = false;
    let isVerifying = false;
    let currentFacingMode = "environment"; // default rear-facing camera on mobile
    const checkInUrl = "{{ route('staff.check-in.store') }}";
    const csrfToken = "{{ csrf_token() }}";

    // Play subtle audio feedback via Web Audio API
    function playBeep(type = 'success') {
        try {
            const ctx = new (window.AudioContext || window.webkitAudioContext)();
            const osc = ctx.createOscillator();
            const gain = ctx.createGain();
            osc.connect(gain);
            gain.connect(ctx.destination);

            if (type === 'success') {
                osc.frequency.setValueAtTime(880, ctx.currentTime); // High pleasant A5
                gain.gain.setValueAtTime(0.15, ctx.currentTime);
                gain.gain.exponentialRampToValueAtTime(0.01, ctx.currentTime + 0.18);
                osc.start(ctx.currentTime);
                osc.stop(ctx.currentTime + 0.18);
            } else if (type === 'duplicate') {
                osc.frequency.setValueAtTime(440, ctx.currentTime); // Lower pitch A4
                gain.gain.setValueAtTime(0.2, ctx.currentTime);
                gain.gain.exponentialRampToValueAtTime(0.01, ctx.currentTime + 0.3);
                osc.start(ctx.currentTime);
                osc.stop(ctx.currentTime + 0.3);
            } else {
                osc.frequency.setValueAtTime(220, ctx.currentTime); // Low buzz
                gain.gain.setValueAtTime(0.2, ctx.currentTime);
                gain.gain.exponentialRampToValueAtTime(0.01, ctx.currentTime + 0.35);
                osc.start(ctx.currentTime);
                osc.stop(ctx.currentTime + 0.35);
            }
        } catch (e) {
            // Audio context not allowed or unsupported
        }
    }

    async function toggleCamera() {
        if (isCameraActive) {
            await stopCamera();
        } else {
            await startCamera();
        }
    }

    async function startCamera() {
        const placeholder = document.getElementById('camera-off-placeholder');
        const scanFrame = document.getElementById('scan-frame');
        const btnLabel = document.getElementById('camera-btn-label');
        const btnIcon = document.getElementById('camera-btn-icon');
        const statusText = document.getElementById('status-text');
        const statusDot = document.getElementById('status-dot');

        try {
            if (!window.Html5Qrcode) {
                alert('Pustaka pemindai belum siap. Pastikan script termuat.');
                return;
            }

            if (!html5QrCode) {
                html5QrCode = new window.Html5Qrcode("qr-reader");
            }

            statusText.textContent = "Menginisialisasi Kamera...";
            statusDot.className = "w-2.5 h-2.5 rounded-full bg-amber-400 animate-pulse";

            const config = {
                fps: 10,
                qrbox: { width: 250, height: 250 },
                aspectRatio: 1.0,
            };

            await html5QrCode.start(
                { facingMode: currentFacingMode },
                config,
                onScanSuccess,
                onScanFailure
            );

            isCameraActive = true;
            placeholder.classList.add('hidden');
            scanFrame.classList.remove('hidden');
            btnLabel.textContent = "Hentikan Kamera";
            btnIcon.textContent = "videocam_off";
            statusText.textContent = "Memindai QR Aktif";
            statusDot.className = "w-2.5 h-2.5 rounded-full bg-emerald-400 animate-pulse";

        } catch (err) {
            console.error("Camera start error:", err);
            statusText.textContent = "Kamera Tidak Tersedia / Ditolak";
            statusDot.className = "w-2.5 h-2.5 rounded-full bg-rose-500";
            alert("Tidak dapat mengakses kamera: " + (err.message || err) + "\n\nPastikan izin kamera telah diberikan di browser atau gunakan form input manual.");
        }
    }

    async function stopCamera() {
        if (html5QrCode && isCameraActive) {
            try {
                await html5QrCode.stop();
            } catch (err) {
                console.error("Camera stop error:", err);
            }
        }

        isCameraActive = false;
        document.getElementById('camera-off-placeholder').classList.remove('hidden');
        document.getElementById('scan-frame').classList.add('hidden');
        document.getElementById('camera-btn-label').textContent = "Aktifkan Kamera";
        document.getElementById('camera-btn-icon').textContent = "videocam";
        document.getElementById('status-text').textContent = "Kamera Nonaktif";
        document.getElementById('status-dot').className = "w-2.5 h-2.5 rounded-full bg-slate-500";
    }

    async function switchCameraFacing() {
        currentFacingMode = (currentFacingMode === "environment") ? "user" : "environment";
        if (isCameraActive) {
            await stopCamera();
            await startCamera();
        }
    }

    function onScanSuccess(decodedText) {
        // Prevent race conditions: discard callback if verification is already in flight
        if (isVerifying) return;
        submitCheckIn(decodedText, 'qr_scanner');
    }

    function onScanFailure(error) {
        // Continuous non-match, no-op
    }

    function handleManualSubmit(e) {
        e.preventDefault();
        const input = document.getElementById('manual-token-input');
        const token = input.value.trim();
        if (!token) return;

        submitCheckIn(token, 'manual_input');
        input.value = '';
    }

    async function submitCheckIn(token, method = 'qr_scanner') {
        isVerifying = true;
        showLoading(true);

        try {
            const response = await fetch(checkInUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                },
                body: JSON.stringify({
                    token: token,
                    check_in_method: method,
                }),
            });

            const data = await response.json();
            renderResult(data);

            if (data.status === 'success') {
                playBeep('success');
                incrementCounter();
                prependRecentCheckIn(data.participant, data.checked_in_at, method);
            } else if (data.status === 'already_checked_in') {
                playBeep('duplicate');
            } else {
                playBeep('error');
            }

        } catch (err) {
            console.error("Check-in request error:", err);
            renderResult({
                status: 'error',
                message: 'Koneksi ke server gagal atau terputus.',
            });
            playBeep('error');
        } finally {
            showLoading(false);
            // Cooldown 1.5s before enabling camera scan again
            setTimeout(() => {
                isVerifying = false;
            }, 1500);
        }
    }

    function showLoading(show) {
        const overlay = document.getElementById('loading-overlay');
        if (show) {
            overlay.classList.remove('hidden');
        } else {
            overlay.classList.add('hidden');
        }
    }

    function renderResult(data) {
        const card = document.getElementById('result-card');
        card.classList.remove('hidden', 'bg-emerald-500/15', 'border-emerald-500/40', 'bg-amber-500/15', 'border-amber-500/40', 'bg-rose-500/15', 'border-rose-500/40');

        if (data.status === 'success') {
            card.classList.add('bg-emerald-500/15', 'border-emerald-500/40');
            card.innerHTML = `
                <div class="flex items-center gap-2 text-emerald-400 font-bold uppercase tracking-wider text-xs">
                    <span class="material-symbols-outlined text-xl">verified</span>
                    <span>Check-in Berhasil</span>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-xs pt-1">
                    <div class="bg-white/5 p-3 rounded-xl border border-white/10">
                        <span class="text-slate-400 block text-[10px] font-medium">Nama Delegasi:</span>
                        <span class="font-bold text-white text-sm">${escapeHtml(data.participant?.name || '-')}</span>
                    </div>
                    <div class="bg-white/5 p-3 rounded-xl border border-white/10">
                        <span class="text-slate-400 block text-[10px] font-medium">Nomor Registrasi:</span>
                        <span class="font-mono text-[#F3E5AB] font-bold text-sm">${escapeHtml(data.participant?.registration_code || '-')}</span>
                    </div>
                    <div class="bg-white/5 p-3 rounded-xl border border-white/10">
                        <span class="text-slate-400 block text-[10px] font-medium">Instansi / Jabatan:</span>
                        <span class="text-slate-200 font-medium">${escapeHtml(data.participant?.company || '-')} (${escapeHtml(data.participant?.position || '-')})</span>
                    </div>
                    <div class="bg-white/5 p-3 rounded-xl border border-white/10">
                        <span class="text-slate-400 block text-[10px] font-medium">Waktu Check-in:</span>
                        <span class="font-mono text-emerald-400 font-bold">${escapeHtml(data.checked_in_at || '-')}</span>
                    </div>
                </div>
                <div class="pt-2">
                    <button type="button" onclick="dismissResult()" class="w-full py-3 bg-emerald-500 hover:bg-emerald-400 text-black font-bold text-xs uppercase tracking-widest rounded-xl transition-all cursor-pointer shadow-lg">
                        Pindai Peserta Berikutnya
                    </button>
                </div>
            `;
        } else if (data.status === 'already_checked_in') {
            card.classList.add('bg-amber-500/15', 'border-amber-500/40');
            card.innerHTML = `
                <div class="flex items-center gap-2 text-amber-400 font-bold uppercase tracking-wider text-xs">
                    <span class="material-symbols-outlined text-xl">warning</span>
                    <span>Peserta Sudah Check-in Sebelumnya</span>
                </div>
                <p class="text-xs text-slate-300">
                    Tiket ini telah digunakan untuk check-in pada: <strong class="text-[#F3E5AB] font-mono">${escapeHtml(data.checked_in_at || '-')}</strong>.
                </p>
                <div class="text-xs bg-white/5 p-3 rounded-xl border border-white/10 space-y-1">
                    <div><span class="text-slate-400">Delegasi:</span> <strong class="text-white">${escapeHtml(data.participant?.name || '-')}</strong></div>
                    <div><span class="text-slate-400">Instansi:</span> <span class="text-slate-200">${escapeHtml(data.participant?.company || '-')}</span></div>
                    <div><span class="text-slate-400">Nomor Registrasi:</span> <span class="font-mono text-[#F3E5AB]">${escapeHtml(data.participant?.registration_code || '-')}</span></div>
                </div>
                <div class="pt-2">
                    <button type="button" onclick="dismissResult()" class="w-full py-3 bg-white/10 hover:bg-white/20 text-white font-semibold text-xs uppercase tracking-widest rounded-xl transition-all cursor-pointer">
                        Kembali ke Pemindai
                    </button>
                </div>
            `;
        } else {
            card.classList.add('bg-rose-500/15', 'border-rose-500/40');
            card.innerHTML = `
                <div class="flex items-center gap-2 text-rose-400 font-bold uppercase tracking-wider text-xs">
                    <span class="material-symbols-outlined text-xl">cancel</span>
                    <span>QR Code Tidak Valid</span>
                </div>
                <p class="text-xs text-slate-200">${escapeHtml(data.message || 'Tiket tidak dikenal atau tidak sesuai dengan acara ini.')}</p>
                <div class="pt-2">
                    <button type="button" onclick="dismissResult()" class="w-full py-3 bg-rose-500/20 hover:bg-rose-500/30 border border-rose-500/40 text-rose-300 font-semibold text-xs uppercase tracking-widest rounded-xl transition-all cursor-pointer">
                        Coba Pindai Lagi
                    </button>
                </div>
            `;
        }

        card.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    }

    function dismissResult() {
        document.getElementById('result-card').classList.add('hidden');
    }

    function incrementCounter() {
        const counter = document.getElementById('stat-total-checkins');
        if (counter) {
            const current = parseInt(counter.textContent.trim(), 10) || 0;
            counter.textContent = current + 1;
        }
    }

    function prependRecentCheckIn(participant, timestamp, method) {
        const tbody = document.getElementById('recent-checkins-body');
        const emptyRow = document.getElementById('no-recent-row');
        if (emptyRow) emptyRow.remove();

        const tr = document.createElement('tr');
        tr.className = 'hover:bg-white/[0.02] transition-colors';
        tr.innerHTML = `
            <td class="py-3 font-semibold text-white">${escapeHtml(participant?.name || '-')}</td>
            <td class="py-3 text-slate-300">${escapeHtml(participant?.company || '-')}</td>
            <td class="py-3 font-mono text-emerald-400">${escapeHtml(timestamp.split(', ')[1] || timestamp)}</td>
            <td class="py-3 text-[10px] uppercase text-slate-400 font-mono">${escapeHtml(method)}</td>
        `;

        tbody.insertBefore(tr, tbody.firstChild);
    }

    function escapeHtml(str) {
        if (!str) return '';
        const div = document.createElement('div');
        div.textContent = str;
        return div.innerHTML;
    }

    // Stop camera stream if staff navigates away
    window.addEventListener('beforeunload', () => {
        if (html5QrCode && isCameraActive) {
            html5QrCode.stop().catch(() => {});
        }
    });
</script>
@endsection
