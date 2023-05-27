<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Site extends Model
{
    use HasFactory;

    protected $table = 'site_info';

    protected $fillable = [
        'title',
        'footerSede',
        'footerPhone',
        'footerMail',
        'footerCopyright',
    ];

    public function desc(): HasMany
    {
        return $this->hasMany(SiteDescriptions::class);
    }

    public function socials(): HasMany
    {
        return $this->hasMany(SiteSocials::class);
    }
}
