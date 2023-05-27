<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiteSocials extends Model
{
    use HasFactory;

    protected $table = 'site_socials';

    protected $fillable = [
        "description",
        "ico",
        "uri",
    ];
}
