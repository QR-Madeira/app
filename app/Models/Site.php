<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Site extends Model
{
    use HasFactory;

    protected $table = 'site_info';

    protected $fillable = [
        'title',
        'desc',
        'footerSede',
        'footerPhone',
        'footerMail',
        'footerCopyright',
    ];
}
