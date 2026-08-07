<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'college_name',
        'college_name_bn',
        'location',
        'location_bn',
        'telephone',
        'cell_phone',
        'ein',
        'nu_code',
        'email',
        'website',
        'address',
        'address_bn',
        'facebook_url',
        'youtube_url',
        'google_map_embed',
        'about_title',
        'about_title_bn',
        'about_description',
        'about_description_bn',
        'about_image_id',
        'founder_name',
        'founder_name_bn',
        'founder_title',
        'founder_title_bn',
        'founder_message',
        'founder_message_bn',
        'founder_image',
        'principal_name',
        'principal_name_bn',
        'principal_title',
        'principal_title_bn',
        'principal_message',
        'principal_message_bn',
        'principal_image',
        'bou_body',
        'bou_body_bn',
        'bou_description',
        'bou_description_bn',
        'is_active',
        'site_language',
    ];

    /**
     * Get the gallery image used for the about section.
     */
    public function aboutImage()
    {
        return $this->belongsTo(Gallery::class, 'about_image_id');
    }
}
