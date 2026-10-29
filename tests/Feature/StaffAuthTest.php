<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class StaffAuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_staff_login_page_renders_successfully(): void
    {
        $response = $this->get(route('staff.login'));

        $response->assertStatus(200);
        $response->assertSee('Masuk Staf Registrasi');
        $response->assertSee('Alamat Email Resmi Staf');
        $response->assertSee('Kata Sandi');
        $response->assertSee('togglePasswordVisibility');
    }

    public function test_valid_staff_credentials_authenticate_successfully(): void
    {
        $staff = User::factory()->create([
            'email' => 'petugas@kek.go.id',
            'password' => Hash::make('secret12345'),
            'role' => 'staff',
        ]);

        $response = $this->post(route('staff.login.store'), [
            'email' => 'PETUGAS@KEK.GO.ID', // test case-insensitivity
            'password' => 'secret12345',
        ]);

        $response->assertRedirect(route('staff.scanner'));
        $this->assertAuthenticatedAs($staff);
    }

    public function test_invalid_credentials_are_rejected_with_generic_error(): void
    {
        User::factory()->create([
            'email' => 'petugas@kek.go.id',
            'password' => Hash::make('correct_password'),
            'role' => 'staff',
        ]);

        $response = $this->post(route('staff.login.store'), [
            'email' => 'petugas@kek.go.id',
            'password' => 'wrong_password',
        ]);

        $response->assertSessionHasErrors(['email']);
        $this->assertGuest();
    }

    public function test_non_staff_role_cannot_login_to_staff_portal(): void
    {
        User::factory()->create([
            'email' => 'participant@gmail.com',
            'password' => Hash::make('password123'),
            'role' => 'participant', // Not a staff role
        ]);

        $response = $this->post(route('staff.login.store'), [
            'email' => 'participant@gmail.com',
            'password' => 'password123',
        ]);

        $response->assertSessionHasErrors(['email']);
        $this->assertGuest();
    }

    public function test_staff_logout_invalidates_session(): void
    {
        $staff = User::factory()->create(['role' => 'staff']);

        $response = $this->actingAs($staff)->post(route('staff.logout'));

        $response->assertRedirect(route('staff.login'));
        $this->assertGuest();
    }

    public function test_unauthenticated_request_cannot_access_scanner(): void
    {
        $response = $this->get(route('staff.scanner'));

        $response->assertRedirect(route('staff.login'));
    }

    public function test_unauthorized_user_receives_403_on_scanner(): void
    {
        $user = User::factory()->create(['role' => 'public_user']);

        $response = $this->actingAs($user)->get(route('staff.scanner'));

        $response->assertStatus(403);
    }

    public function test_unauthenticated_json_request_to_checkin_returns_401(): void
    {
        $response = $this->postJson(route('staff.check-in.store'), [
            'token' => 'dummy-token',
        ]);

        $response->assertStatus(401);
        $response->assertJson([
            'message' => 'Unauthenticated.',
        ]);
    }
}
