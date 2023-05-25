<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Site extends Model
{
    use HasFactory;

    protected $table = 'attractions';

    protected $fillable = [
        'titlePt',
        'titleEng',
        'descPt',
        'descEng',
        'footer',
    ];
}
