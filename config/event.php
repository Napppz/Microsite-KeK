<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Event Configuration & Placeholders
    |--------------------------------------------------------------------------
    |
    | Centralized settings for the KEK Business Forum microsite.
    | Unconfirmed event details remain configurable placeholders.
    |
    */

    'name' => env('EVENT_NAME', 'KEK Business Forum'),
    'year' => env('EVENT_YEAR', '2025'),
    'edition' => env('EVENT_EDITION', 'Edisi Konferensi 2025'),
    'organizer' => env('EVENT_ORGANIZER', '[Sekretariat Jenderal Dewan Nasional KEK]'),
    'ministry' => env('EVENT_MINISTRY', 'Kementerian Koordinator Bidang Perekonomian'),
    'dates' => env('EVENT_DATES', '[Tanggal Pelaksanaan Acara]'),
    'time_schedule' => env('EVENT_TIME_SCHEDULE', '08.30 – 17.30 WIB • 2 Hari Kerja'),
    'venue_name' => env('EVENT_VENUE_NAME', '[Nama Gedung & Lokasi Acara]'),
    'venue_address' => env('EVENT_VENUE_ADDRESS', 'Jl. Gatot Subroto No. 1, Senayan, Jakarta Pusat 10270'),
    'venue_hint' => env('EVENT_VENUE_HINT', 'Jakarta Convention Center (JCC), Senayan'),
    'target_investment' => env('EVENT_TARGET_INVESTMENT', 'IDR 175 Triliun'),
    'target_delegates' => env('EVENT_TARGET_DELEGATES', '50+ Negara'),
    'fiscal_facility' => env('EVENT_FISCAL_FACILITY', 'Hingga 100%'),
    'bilateral_sessions' => env('EVENT_BILATERAL_SESSIONS', '1-on-1 Matching'),
    'speakers' => [
        [
            'role' => 'Pemerintah Republik Indonesia',
            'name' => '[Perwakilan Pembuat Kebijakan]',
            'title' => 'Menteri Koordinator Bidang Perekonomian RI / Ketua Dewan Nasional KEK. Mengarahkan integrasi kebijakan fiskal dan tata ruang investasi strategis nasional.',
            'image' => 'images/kek/speaker-1-pembuat-kebijakan.jpg',
        ],
        [
            'role' => 'Sekretariat Jenderal Dewan Nasional KEK',
            'name' => '[Pimpinan Pengelola Kawasan]',
            'title' => 'Pelaksana Tugas Sekretaris Jenderal Dewan Nasional KEK. Memaparkan evaluasi kemajuan realisasi investasi dan kepatuhan fasilitas insentif satu pintu OSS.',
            'image' => 'images/kek/speaker-2-pengelola-kawasan.jpg',
        ],
        [
            'role' => 'Sektor Swasta & Multinasional',
            'name' => '[Pemimpin Industri Global]',
            'title' => 'Ketua Konsorsium Badan Usaha Pengembang KEK & KADIN Indonesia. Menyoroti kolaborasi konglomerasi swasta dengan penanaman modal asing untuk rantai pasok hilir.',
            'image' => 'images/kek/speaker-3-industri-global.jpg',
        ],
    ],
];
