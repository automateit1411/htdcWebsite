<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyAttendance extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'date' => 'date',
        'percentage' => 'decimal:2',
    ];

    public function programGroup()
    {
        return $this->belongsTo(ProgramGroup::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($attendance) {
            if ($attendance->total_students > 0) {
                $attendance->percentage = ($attendance->present_students / $attendance->total_students) * 100;
            } else {
                $attendance->percentage = 0;
            }
            $attendance->absent_students = $attendance->total_students - $attendance->present_students;
        });
    }
}
