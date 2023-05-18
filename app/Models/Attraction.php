<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attraction extends Model
{
    use HasFactory;

    protected $table = 'attractions';

    protected $fillable = [
        'title_compiled',
        'title',
        'description',
        'image',
        'site_url',
        'qr_code_path',
        'created_by',
        "lat",
        "lon",
    ];
}
