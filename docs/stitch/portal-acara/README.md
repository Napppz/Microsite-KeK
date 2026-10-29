# Referensi Desain Google Stitch — Portal Acara KEK Business Forum 2025

Dokumen ini berisi informasi metadata, inventaris aset, dan panduan integrasi untuk desain yang diambil langsung dari Google Stitch MCP.

---

## 1. Metadata Proyek & Layar

- **Platform Sumber**: Google Stitch MCP (`stitch`)
- **Nama Proyek**: KEK Business Forum Microsite
- **Project ID**: `13518029913514023229`
- **Resource Proyek**: `projects/13518029913514023229`
- **Nama Layar**: Portal Acara KEK Business Forum 2025 (Editorial Redesign)
- **Screen ID**: `5a4e29a75b6641cd841b88c1d4178a8c`
- **Resource Layar**: `projects/13518029913514023229/screens/5a4e29a75b6641cd841b88c1d4178a8c`
- **Resolusi Asli Layar**: 2560 x 12266 px (Desktop)
- **Desain Sistem**: *Sovereign Portal* (Fidelity / Editorial Executive)

---

## 2. Struktur Direktori Berkas Referensi

```text
docs/stitch/portal-acara/
├── screen.html                     # Kode HTML lengkap dari Stitch MCP (30,160 karakter)
├── screenshot.png                  # Gambar tangkapan layar penuh dari Stitch MCP (~8.1 MB)
├── design_system.md                # Spesifikasi lengkap Design System 'Sovereign Portal'
├── project_meta.json               # Metadata mentah proyek dan screen
├── README.md                       # Dokumentasi referensi ini
└── assets/
    └── images/
        ├── hero-plenary.jpg        # Foto Pleno KEK Business Forum 2025 (70,279 bytes)
        ├── speaker-1-pembuat-kebijakan.jpg # Foto Narasumber 1 - Pembuat Kebijakan (74,037 bytes)
        ├── speaker-2-pengelola-kawasan.jpg # Foto Narasumber 2 - Pengelola Kawasan (41,835 bytes)
        ├── speaker-3-industri-global.jpg   # Foto Narasumber 3 - Industri Global (47,202 bytes)
        └── venue-jcc.jpg           # Foto / Denah Lokasi JCC Senayan (121,917 bytes)
```

---

## 3. Inventaris Aset & Asal URL

| Nama Berkas Lokal | Tipe | Ukuran | Validasi Header | URL Asal (Hosted URL) |
|---|---|---|---|---|
| `screenshot.png` | PNG | 8,115,657 bytes | Valid PNG (`89 50 4E 47`) | `projects/13518029913514023229/screens/5a4e29a75b6641cd841b88c1d4178a8c/fileEntries/screenshot` (via Stitch MCP `download_file`) |
| `hero-plenary.jpg` | JPEG | 70,279 bytes | Valid JPEG (`FF D8 FF`) | `https://lh3.googleusercontent.com/aida-public/AB6AXuDoNiW19m_...` |
| `speaker-1-pembuat-kebijakan.jpg` | JPEG | 74,037 bytes | Valid JPEG (`FF D8 FF`) | `https://lh3.googleusercontent.com/aida-public/AB6AXuCHSljF1HD...` |
| `speaker-2-pengelola-kawasan.jpg` | JPEG | 41,835 bytes | Valid JPEG (`FF D8 FF`) | `https://lh3.googleusercontent.com/aida-public/AB6AXuCcrDCJ9ZM...` |
| `speaker-3-industri-global.jpg` | JPEG | 47,202 bytes | Valid JPEG (`FF D8 FF`) | `https://lh3.googleusercontent.com/aida-public/AB6AXuB5CB3S-CE...` |
| `venue-jcc.jpg` | PNG | 121,917 bytes | Valid PNG (`89 50 4E 47`) | `https://lh3.googleusercontent.com/aida-public/AB6AXuDebNbKF3i...` |

---

## 4. Analisis Teknologi Frontend & Dependensi

1. **Struktur & Styling**:
   - Berkas HTML menggunakan **Tailwind CSS v3 via CDN script** (`https://cdn.tailwindcss.com?plugins=forms,container-queries`).
   - Terdapat inline custom tailwind config dengan palet `brand`:
     - `brand-ivory`: `#F7F7F4` (background utama)
     - `brand-subtle`: `#EFEFEA`
     - `brand-dark`: `#101820` (warna gelap institusional / navbar / hero)
     - `brand-navy`: `#183B5B` (corporate blue untuk tag/aksen)
     - `brand-amber`: `#E9A443` (investment gold / CTA primer)
     - `brand-muted`: `#5B6471` / `#64748B` (teks sekunder)
2. **Tipografi (Google Fonts)**:
   - **Serif / Editorial**: `Newsreader` (`weights: 300..700`, italic opsz 6..72) — digunakan untuk heading besar (H1, H2, H3) dan angka metrik penting.
   - **Sans-Serif**: `Work Sans` (`weights: 300..700`) — digunakan untuk body text, navigasi, dan label.
   - *Catatan Design System Proyek*: Memiliki fallback atau padanan `Inter` untuk tabular numbers.
3. **Ikon**:
   - `Material Symbols Outlined` via Google Fonts.
4. **Interaktivitas JavaScript**:
   - Minimalis (inline form submit interceptor sederhana dengan `event.preventDefault()`).

---

## 5. Rincian Data Placeholder yang Memerlukan Konfirmasi

Kode desain Stitch mengandung beberapa penanda placeholder yang sengaja tidak di-hardcode:
- **Tanggal Pelaksanaan**: Tertulis `[Tanggal Pelaksanaan Acara]`, estimasi `08.30 – 17.30 WIB • 2 Hari Kerja`.
- **Nama Gedung & Lokasi Acara**: Tertulis `[Nama Gedung & Lokasi Acara]`, alamat sementara `Jakarta Convention Center (JCC), Senayan, Jl. Gatot Subroto No. 1`.
- **Penyelenggara**: Tertulis `[Sekretariat Jenderal Dewan Nasional KEK], Kementerian Koordinator Bidang Perekonomian`.
- **Narasumber**:
  - `[Perwakilan Pembuat Kebijakan]` (Menteri Koordinator Bidang Perekonomian RI)
  - `[Pimpinan Pengelola Kawasan]` (Pelaksana Tugas Sekretaris Jenderal Dewan Nasional KEK)
  - `[Pemimpin Industri Global]` (Ketua Konsorsium Badan Usaha Pengembang KEK & KADIN Indonesia)
- **Target Investasi & Statistik**: Menampilkan figur placeholder IDR 175 Triliun dan 50+ Negara yang perlu verifikasi dari sekretariat panitia KEK.

---

## 6. Rekomendasi Integrasi ke Laravel Blade

1. **Pemindahan Aset Statis**:
   - Salin berkas gambar dari `docs/stitch/portal-acara/assets/images/` ke `public/images/kek/` atau `resources/images/`.
   - Di Blade, gunakan helper standar `{{ asset('images/kek/hero-plenary.jpg') }}`.
2. **Pengelolaan Styling CSS**:
   - Jika project Laravel menggunakan Vite + Tailwind CSS:
     - Daftarkan palet warna (`brand-ivory`, `brand-dark`, `brand-navy`, `brand-amber`, `brand-muted`) dan font family (`Newsreader`, `Work Sans`) ke dalam `tailwind.config.js`.
   - Jika menggunakan Vanilla CSS:
     - Buat berkas CSS spesifik di `public/css/portal-acara.css` atau bundle Vite dengan variabel CSS root (`--color-brand-dark`, `--color-brand-amber`, dll.).
3. **Komponenisasi Blade**:
   - Pecah tampilan menjadi sub-komponen terstruktur:
     - `components/navbar.blade.php`
     - `components/hero.blade.php`
     - `components/overview.blade.php`
     - `components/about.blade.php`
     - `components/agenda.blade.php`
     - `components/speakers.blade.php`
     - `components/location.blade.php`
     - `components/registration-cta.blade.php`
     - `components/footer.blade.php`
4. **Form Registrasi & CSRF**:
   - Pasang direktif `@csrf` dan hubungkan form ke Laravel Controller (`Route::post('/registrasi', [RegistrationController::class, 'store'])`).
