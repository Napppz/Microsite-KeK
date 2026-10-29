<!DOCTYPE html>
<html class="scroll-smooth" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('event.name') . ' ' . config('event.year') . ' — Akselerasi Investasi Strategis')</title>
    <meta name="description" content="@yield('meta_description', 'Portal resmi KEK Business Forum — Menghubungkan kepastian regulasi dengan realisasi permodalan global dalam satu meja perundingan.')">

    <!-- Official KEK Google Fonts: Inter (Headings & Display) & Nunito Sans (Body & UI) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Nunito+Sans:ital,opsz,wght@0,6..12,300;0,6..12,400;0,6..12,500;0,6..12,600;0,6..12,700;0,6..12,800;0,6..12,900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">

    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="bg-[#060A10] text-[#E2E8F0] min-h-screen flex flex-col selection:bg-[#F59E0B] selection:text-[#060A10] font-sans antialiased relative overflow-x-hidden">
    <!-- Ambient Background Lighting Orbs -->
    <div class="fixed top-0 left-1/4 w-[600px] h-[600px] bg-gradient-to-br from-[#1E3A8A]/15 to-[#F59E0B]/10 rounded-full blur-[140px] pointer-events-none -z-10"></div>
    <div class="fixed bottom-0 right-10 w-[500px] h-[500px] bg-gradient-to-tl from-[#1E3A8A]/10 to-transparent rounded-full blur-[130px] pointer-events-none -z-10"></div>

    <x-navbar />

    <main id="main-content" class="w-full flex-1">
        @yield('content')
    </main>

    <x-footer />
    @stack('scripts')
</body>
</html>
