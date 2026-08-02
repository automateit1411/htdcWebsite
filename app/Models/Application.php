<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * Get the absolute URL for the student picture.
     */
    public function getSPictureAttribute($value)
    {
        if (empty($value)) return null;

        // Return full URL if it's already a full URL or base64
        if (filter_var($value, FILTER_VALIDATE_URL) || preg_match('/^data:image/', $value)) {
            return $value;
        }

        return asset($value);
    }
}
