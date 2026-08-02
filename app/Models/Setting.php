<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'college_name',
        'location',
        'telephone',
        'cell_phone',
        'ein',
        'nu_code',
        'email',
        'website',
        'address',
        'facebook_url',
        'youtube_url',
        'google_map_embed',
        'about_title',
        'about_description',
        'about_image_id',
        'founder_name',
        'founder_title',
        'founder_message',
        'founder_image',
        'principal_name',
        'principal_title',
        'principal_message',
        'principal_image',
        'bou_body',
        'bou_description',
        'is_active',
    ];

    /**
     * Get the gallery image used for the about section.
     */
    public function aboutImage()
    {
        return $this->belongsTo(Gallery::class, 'about_image_id');
    }
}
