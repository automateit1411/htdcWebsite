<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeacherVacantPost extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'file_path',
        'is_active',
    ];

    public function isNew()
    {
        return $this->created_at->gt(now()->subDays(7));
    }
}
