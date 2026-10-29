<?php

namespace Tests\Feature;

use App\Models\Event;
use App\Models\Registration;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    private function validPayload(array $overrides = []): array
    {
        return array_merge([
            'full_name' => 'Dr. Ir. Budi Santoso, M.B.A.',
            'email' => 'Budi.Santoso@Perusahaan.co.id',
            'phone_number' => '+62 812-3456-7890',
            'position' => 'Chief Investment Officer',
            'company_name' => 'PT Mandiri Nusantara Infrastruktur',
            'organization_type' => 'swasta',
            'country' => 'ID',
            'city' => 'Jakarta Selatan',
            'participation_category' => 'investor',
            'sectors' => ['nikel', 'datacenter'],
            'sessions' => ['plenary', 'b2b'],
            'privacy_agreed' => '1',
        ], $overrides);
    }

    public function test_registration_form_view_renders_successfully(): void
    {
        $response = $this->get('/registrasi');

        $response->assertStatus(200);
        $response->assertSee('Formulir Registrasi Peserta &amp; Delegasi', false);
        $response->assertSee('Data Diri Delegasi', false);
        $response->assertSee('Informasi Organisasi &amp; Entitas', false);
        $response->assertSee('Kategori Partisipasi &amp; Sektor KEK', false);
        $response->assertSee('Sesi yang Hendak Diikuti', false);
        $response->assertSee('Undang-Undang Perlindungan Data Pribadi', false);
    }

    public function test_valid_registration_is_persisted_to_database(): void
    {
        $payload = $this->validPayload();

        $response = $this->post('/registrasi', $payload);

        $this->assertDatabaseHas('registrations', [
            'full_name' => 'Dr. Ir. Budi Santoso, M.B.A.',
            'email' => 'budi.santoso@perusahaan.co.id', // normalized lowercase
            'phone_number' => '+62 812-3456-7890',
            'position' => 'Chief Investment Officer',
            'company_name' => 'PT Mandiri Nusantara Infrastruktur',
            'organization_type' => 'swasta',
            'country' => 'ID',
            'city' => 'Jakarta Selatan',
            'participation_category' => 'investor',
            'privacy_agreed' => true,
            'status' => 'pending_verification',
        ]);

        $registration = Registration::where('email', 'budi.santoso@perusahaan.co.id')->first();
        $this->assertNotNull($registration);
        $this->assertMatchesRegularExpression('/^KEK-\d{4}-DLG-\d{4}$/', $registration->registration_code);
        $this->assertEquals(Event::current()->id, $registration->event_id);

        $response->assertRedirect(route('registration.success', ['code' => $registration->registration_code]));
    }

    public function test_required_fields_validation(): void
    {
        $response = $this->post('/registrasi', []);

        $response->assertSessionHasErrors([
            'full_name',
            'email',
            'phone_number',
            'position',
            'company_name',
            'organization_type',
            'country',
            'city',
            'privacy_agreed',
        ]);

        $this->assertEquals(0, Registration::count());
    }

    public function test_invalid_email_is_rejected(): void
    {
        $payload = $this->validPayload(['email' => 'not-an-email']);

        $response = $this->post('/registrasi', $payload);

        $response->assertSessionHasErrors(['email']);
        $this->assertEquals(0, Registration::count());
    }

    public function test_privacy_consent_is_required(): void
    {
        $payload = $this->validPayload();
        unset($payload['privacy_agreed']);

        $response = $this->post('/registrasi', $payload);

        $response->assertSessionHasErrors(['privacy_agreed']);
        $this->assertEquals(0, Registration::count());
    }

    public function test_duplicate_registration_with_same_email_is_rejected(): void
    {
        $payload1 = $this->validPayload(['email' => 'delegasi@investor.com']);
        $this->post('/registrasi', $payload1)->assertSessionHasNoErrors();
        $this->assertEquals(1, Registration::count());

        // Attempt second registration with same email (different case)
        $payload2 = $this->validPayload(['email' => 'DELEGASI@INVESTOR.COM', 'full_name' => 'Nama Lain']);
        $response2 = $this->post('/registrasi', $payload2);

        $response2->assertSessionHasErrors(['email']);
        $this->assertEquals(1, Registration::count());
    }

    public function test_registration_is_associated_with_correct_event(): void
    {
        $event = Event::current();
        $payload = $this->validPayload();

        $this->post('/registrasi', $payload);

        $registration = Registration::first();
        $this->assertEquals($event->id, $registration->event_id);
        $this->assertEquals($event->slug, $registration->event->slug);
    }

    public function test_confirmation_page_displays_reference_code_and_details(): void
    {
        $event = Event::current();
        $registration = Registration::create([
            'event_id' => $event->id,
            'registration_code' => 'KEK-2025-DLG-7799',
            'full_name' => 'Ir. Siti Rahma, M.Sc.',
            'email' => 'siti.rahma@globalenergi.id',
            'phone_number' => '+62 811-9988-7766',
            'position' => 'Head of Renewable Projects',
            'company_name' => 'PT Global Energi Nusantara',
            'organization_type' => 'fdi',
            'country' => 'ID',
            'city' => 'Surabaya',
            'participation_category' => 'speaker',
            'privacy_agreed' => true,
            'status' => 'pending_verification',
        ]);

        $response = $this->get(route('registration.success', ['code' => 'KEK-2025-DLG-7799']));

        $response->assertStatus(200);
        $response->assertSee('KEK-2025-DLG-7799');
        $response->assertSee('Ir. Siti Rahma, M.Sc.');
        $response->assertSee('PT Global Energi Nusantara');
        $response->assertSee('Menunggu Verifikasi Protokoler');
    }
}
