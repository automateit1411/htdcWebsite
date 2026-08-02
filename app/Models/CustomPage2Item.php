<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomPage2Item extends Model
{
    use HasFactory;

    protected $table = 'custom_page_2_items';
    protected $fillable = ['custom_page_2_id', 'title', 'description', 'image_path', 'file_path', 'order'];

    public function page()
    {
        return $this->belongsTo(CustomPage2::class, 'custom_page_2_id');
    }
}
