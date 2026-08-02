<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomPage extends Model
{
    use HasFactory;

    protected $fillable = [
        'page_name',
        'category',
        'subcategory',
        'title',
        'file_path',
        'image_path',
        'description',
        'route',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];
}
