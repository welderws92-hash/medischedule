<?php

namespace Tests\Feature;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Specialty;
use App\Models\User;
use App\Services\AppointmentService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AppointmentConflictTest extends TestCase
{
    use RefreshDatabase;

    public function test_detects_overlapping_appointment_for_same_doctor(): void
    {
        $patient = User::factory()->create([
            'role' => 'patient',
        ]);

        $doctorUser = User::factory()->create([
            'role' => 'doctor',
        ]);

        $specialty = Specialty::create([
            'name' => 'Clínica Geral',
        ]);

        $doctor = Doctor::create([
            'user_id' => $doctorUser->id,
            'specialty_id' => $specialty->id,
            'crm' => 'CRM-TESTE-001',
            'is_active' => true,
        ]);

        Appointment::create([
            'patient_id' => $patient->id,
            'doctor_id' => $doctor->id,
            'appointment_date' => '2026-11-10',
            'start_time' => '14:00',
            'end_time' => '14:30',
            'status' => 'scheduled',
        ]);

        $service = new AppointmentService();

        $hasConflict = $service->doctorHasConflict(
            $doctor->id,
            '2026-11-10',
            '14:15',
            '14:45'
        );

        $this->assertTrue($hasConflict);
    }
    
    public function test_allows_appointment_starting_when_previous_one_ends(): void
    {
        $patient = User::factory()->create([
            'role' => 'patient',
        ]);

        $doctorUser = User::factory()->create([
            'role' => 'doctor',
        ]);

        $specialty = Specialty::create([
            'name' => 'Pediatria',
        ]);

        $doctor = Doctor::create([
            'user_id' => $doctorUser->id,
            'specialty_id' => $specialty->id,
            'crm' => 'CRM-TESTE-002',
            'is_active' => true,
        ]);

        Appointment::create([
            'patient_id' => $patient->id,
            'doctor_id' => $doctor->id,
            'appointment_date' => '2026-11-10',
            'start_time' => '14:00',
            'end_time' => '14:30',
            'status' => 'scheduled',
        ]);

        $service = new AppointmentService();

        $hasConflict = $service->doctorHasConflict(
            $doctor->id,
            '2026-11-10',
            '14:30',
            '15:00'
        );

        $this->assertFalse($hasConflict);
    }

}
