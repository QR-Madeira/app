<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attractions_Pictures extends Model
{
    use HasFactory;

    protected $table = 'attractions_pictures';

    protected $fillable = [
      'belonged_attraction',
      'image_path',
      'description',
    ];
}
