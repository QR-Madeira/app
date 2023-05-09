<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attractions_Close_Locations extends Model
{
    use HasFactory;

    protected $table = 'attractions_close_locations';

    protected $fillable = [
      'belonged_attraction',
      'icon_path',
      'name',
      'location',
      'phone',
    ];
}
