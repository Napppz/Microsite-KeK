<?php

namespace Tests\Feature;

use Tests\TestCase;

class LandingPageTest extends TestCase
{
    public function test_landing_page_renders_successfully(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('KEK BUSINESS FORUM', false);
        $response->assertSee('Akselerasi Investasi Strategis &amp; Masa Depan Industri Kawasan', false);
    }

    public function test_landing_page_contains_all_key_sections(): void
    {
        $response = $this->get('/');

        // Navbar anchors & CTA
        $response->assertSee('href="#tentang"', false);
        $response->assertSee('href="#agenda"', false);
        $response->assertDontSee('href="#narasumber"', false);
        $response->assertSee('href="#lokasi"', false);
        $response->assertSee('Daftar Sekarang', false);

        // Hero Section
        $response->assertSee('Forum Tingkat Tinggi Tahunan', false);
        $response->assertSee('Dewan Nasional Kawasan Ekonomi Khusus', false);
        $response->assertSee('hero-plenary.jpg', false);

        // Overview Ledger
        $response->assertSee('Tanggal Pelaksanaan', false);
        $response->assertSee('Tempat &amp; Lokasi', false);
        $response->assertSee('Penyelenggara', false);
        $response->assertSee('Format Partisipasi', false);

        // About Section
        $response->assertSee('Tujuan &amp; Urgensi Forum', false);
        $response->assertSee('22+', false);
        $response->assertSee('Hilirisasi &amp; Rantai Pasok Berkelanjutan', false);
        $response->assertSee('Penyederhanaan Tata Kelola Satu Pintu', false);

        // Agenda Section
        $response->assertSee('Agenda Resmi Forum', false);
        $response->assertSee('08.30 – 10.00', false);
        $response->assertSee('10.30 – 12.30', false);
        $response->assertSee('13.30 – 15.00', false);
        $response->assertSee('15.30 – 17.30', false);

        // Speakers Section Removed per Organizer Request
        $response->assertDontSee('Narasumber Kehormatan', false);
        $response->assertDontSee('Tokoh &amp; Pembicara Kunci', false);

        // Location Section
        $response->assertSee('Akomodasi &amp; Protokol Delegasi', false);
        $response->assertSee('venue-jcc.jpg', false);

        // Registration CTA trigger
        $response->assertSee('Konfirmasi Kehadiran Delegasi Resmi Anda', false);
        $response->assertSee('action="' . route('registration.create') . '"', false);

        // Footer Section
        $response->assertSee('Sekretariat Pelaksana', false);
        $response->assertSee('info@kek.go.id', false);
    }

    public function test_all_retrieved_images_exist_on_disk(): void
    {
        $images = [
            'public/images/kek/hero-plenary.jpg',
            'public/images/kek/speaker-1-pembuat-kebijakan.jpg',
            'public/images/kek/speaker-2-pengelola-kawasan.jpg',
            'public/images/kek/speaker-3-industri-global.jpg',
            'public/images/kek/venue-jcc.jpg',
        ];

        foreach ($images as $img) {
            $this->assertFileExists(base_path($img), "Image file {$img} must exist on disk.");
            $this->assertGreaterThan(0, filesize(base_path($img)), "Image file {$img} must not be empty.");
        }
    }
}
