<?php

namespace App\Services;

use App\Models\Appointment;
use App\Models\DoctorSchedule;
use Carbon\Carbon;

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

    /**
     * Verifica se a consulta respeita o expediente e os
     * intervalos de atendimento configurados para o médico.
     */
    public function fitsDoctorSchedule(
        int $doctorId,
        string $date,
        string $startTime,
        string $endTime
    ): bool {
        $weekday = Carbon::parse($date)->dayOfWeek;

        $schedules = DoctorSchedule::query()
            ->where('doctor_id', $doctorId)
            ->where('weekday', $weekday)
            ->where('is_active', true)
            ->where('start_time', '<=', $startTime)
            ->where('end_time', '>=', $endTime)
            ->get();

        foreach ($schedules as $schedule) {
            $scheduleStart = Carbon::parse($date.' '.$schedule->start_time);
            $appointmentStart = Carbon::parse($date.' '.$startTime);
            $appointmentEnd = Carbon::parse($date.' '.$endTime);

            $duration = $schedule->slot_duration_minutes;

            if ($duration <= 0) {
                continue;
            }

            $minutesFromStart = (int) $scheduleStart->diffInMinutes(
                $appointmentStart,
                false
            );

            $appointmentDuration = (int) $appointmentStart->diffInMinutes(
                $appointmentEnd,
                false
            );
            if (
                $minutesFromStart >= 0
                && $minutesFromStart % $duration === 0
                && $appointmentDuration === $duration
            ) {
                return true;
            }
        }

        return false;
    }
}
