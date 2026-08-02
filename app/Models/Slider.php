<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    use HasFactory;

    protected $fillable = [
        'image_id',
        'title',
        'order',
        'is_active',
    ];

    /**
     * Get the gallery image associated with the slider.
     */
    public function image()
    {
        return $this->belongsTo(Gallery::class, 'image_id');
    }
}
