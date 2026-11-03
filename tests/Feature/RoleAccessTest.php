<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class RoleAccessTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Route::middleware(['web', 'auth', 'role:admin'])
            ->get('/teste-admin', function () {
                return response()->json(['message' => 'Acesso permitido']);
            });
    }

    public function test_admin_can_access_admin_area(): void
    {
        $admin = User::factory()->admin()->create();

        $response = $this->actingAs($admin)->get('/teste-admin');

        $response->assertOk();
    }

    public function test_patient_cannot_access_admin_area(): void
    {
        $patient = User::factory()->patient()->create();

        $response = $this->actingAs($patient)->get('/teste-admin');

        $response->assertForbidden();
    }

    public function test_doctor_cannot_access_admin_area(): void
    {
        $doctor = User::factory()->doctor()->create();

        $response = $this->actingAs($doctor)->get('/teste-admin');

        $response->assertForbidden();
    }

    public function test_guest_cannot_access_admin_area(): void
    {
        $response = $this->get('/teste-admin');

        $response->assertRedirect(route('login'));
    }
}
