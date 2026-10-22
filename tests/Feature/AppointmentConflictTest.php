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
   public function test_detects_overlapping_appointments_for_same_patient_with_different_doctors(): void
    {
        $patient = User::factory()->create([
            'role' => 'patient',
        ]);

        $specialty = Specialty::create([
            'name' => 'Cardiologia',
        ]);

        $firstDoctorUser = User::factory()->create([
            'role' => 'doctor',
        ]);

        $secondDoctorUser = User::factory()->create([
            'role' => 'doctor',
        ]);

        $firstDoctor = Doctor::create([
            'user_id' => $firstDoctorUser->id,
            'specialty_id' => $specialty->id,
            'crm' => 'CRM-TESTE-003',
            'is_active' => true,
        ]);

        $secondDoctor = Doctor::create([
            'user_id' => $secondDoctorUser->id,
            'specialty_id' => $specialty->id,
            'crm' => 'CRM-TESTE-004',
            'is_active' => true,
        ]);

        Appointment::create([
            'patient_id' => $patient->id,
            'doctor_id' => $firstDoctor->id,
            'appointment_date' => '2026-11-10',
            'start_time' => '14:00',
            'end_time' => '14:30',
            'status' => 'scheduled',
        ]);

        $service = new AppointmentService();

        $hasConflict = $service->patientHasConflict(
            $patient->id,
            '2026-11-10',
            '14:15',
            '14:45'
        );

        $this->assertTrue($hasConflict);
    }

    public function test_allows_patient_appointment_when_previous_one_ends(): void
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
            'crm' => 'CRM-TESTE-005',
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

        $hasConflict = $service->patientHasConflict(
            $patient->id,
            '2026-11-10',
            '14:30',
            '15:00'
        );

        $this->assertFalse($hasConflict);
    }

    public function test_allows_appointment_inside_doctor_schedule(): void
    {
        $doctorUser = User::factory()->create([
            'role' => 'doctor',
        ]);

        $specialty = Specialty::create([
            'name' => 'Ortopedia',
        ]);

        $doctor = Doctor::create([
            'user_id' => $doctorUser->id,
            'specialty_id' => $specialty->id,
            'crm' => 'CRM-TESTE-006',
            'is_active' => true,
        ]);

        \App\Models\DoctorSchedule::create([
            'doctor_id' => $doctor->id,
            'weekday' => 2,
            'start_time' => '08:00',
            'end_time' => '17:00',
            'slot_duration_minutes' => 30,
            'is_active' => true,
        ]);

        $service = new AppointmentService();

        $fits = $service->fitsDoctorSchedule(
            $doctor->id,
            '2026-11-10',
            '09:00',
            '09:30'
        );

        $this->assertTrue($fits);
    }

    public function test_rejects_appointment_ending_after_doctor_schedule(): void
    {
        $doctorUser = User::factory()->create([
            'role' => 'doctor',
        ]);

        $specialty = Specialty::create([
            'name' => 'Oftalmologia',
        ]);

        $doctor = Doctor::create([
            'user_id' => $doctorUser->id,
            'specialty_id' => $specialty->id,
            'crm' => 'CRM-TESTE-007',
            'is_active' => true,
        ]);

        \App\Models\DoctorSchedule::create([
            'doctor_id' => $doctor->id,
            'weekday' => 2,
            'start_time' => '08:00',
            'end_time' => '17:00',
            'slot_duration_minutes' => 30,
            'is_active' => true,
        ]);

        $service = new AppointmentService();

        $fits = $service->fitsDoctorSchedule(
            $doctor->id,
            '2026-11-10',
            '16:45',
            '17:15'
        );

        $this->assertFalse($fits);
    }


}
