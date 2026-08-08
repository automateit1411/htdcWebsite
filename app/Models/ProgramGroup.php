<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgramGroup extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'program_id',
    ];

    public function attendances()
    {
        return $this->hasMany(DailyAttendance::class);
    }
}
