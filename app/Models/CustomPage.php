<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomPage extends Model
{
    use HasFactory;

    protected $fillable = [
        'page_name',
        'page_name_bn',
        'category',
        'category_bn',
        'subcategory',
        'subcategory_bn',
        'title',
        'title_bn',
        'file_path',
        'image_path',
        'description',
        'description_bn',
        'route',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];
}
