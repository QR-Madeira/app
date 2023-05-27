<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Attraction extends Model
{
    use HasFactory;

    protected $table = 'attractions';

    protected $fillable = [
        'title_compiled',
        'title',
        'image',
        'site_url',
        'qr_code_path',
        'created_by',
        "lat",
        "lon",
    ];

    public function description(): HasMany
    {
        return $this->hasMany(AttractionDescriptions::class);
    }
}
