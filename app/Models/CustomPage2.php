<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomPage2 extends Model
{
    use HasFactory;

    protected $table = 'custom_page_2s';
    protected $fillable = ['page_name', 'page_name_bn', 'title', 'title_bn', 'description', 'description_bn', 'slug', 'route', 'status'];

    protected $casts = ['status' => 'boolean'];

    public function items()
    {
        return $this->hasMany(CustomPage2Item::class, 'custom_page_2_id')->orderBy('id', 'desc');
    }
}
