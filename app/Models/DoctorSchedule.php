
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DoctorSchedule extends Model
{
    protected $fillable = [
        'doctor_id',
        'weekday',
        'start_time',
        'end_time',
        'slot_duration_minutes',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'weekday' => 'integer',
            'slot_duration_minutes' => 'integer',
            'is_active' => 'boolean',
        ];
    }

    public function doctor(): BelongsTo
    {
        return $this->belongsTo(Doctor::class);
    }
}
