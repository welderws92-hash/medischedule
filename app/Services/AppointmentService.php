<?php

namespace App\Services;

use App\Models\Appointment;
use Illuminate\Database\Eloquent\Builder;

class AppointmentService
{
    /**
     * Verifica se um médico já possui consulta nesse intervalo.
     */
    public function doctorHasConflict(
        int $doctorId,
        string $date,
        string $startTime,
        string $endTime
    ): bool {
        return Appointment::query()
            ->where('doctor_id', $doctorId)
            ->whereDate('appointment_date', $date)
            ->where('status', '!=', 'canceled')
            ->where('start_time', '<', $endTime)
            ->where('end_time', '>', $startTime)
            ->exists();
    }

    /**
     * Verifica se um paciente já possui consulta nesse intervalo.
     */
    public function patientHasConflict(
        int $patientId,
        string $date,
        string $startTime,
        string $endTime
    ): bool {
        return Appointment::query()
            ->where('patient_id', $patientId)
            ->whereDate('appointment_date', $date)
            ->where('status', '!=', 'canceled')
            ->where('start_time', '<', $endTime)
            ->where('end_time', '>', $startTime)
            ->exists();
    }
}