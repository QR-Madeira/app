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
    'image_path',
    'site_url',
    'qr-code_path',
    'created_by'
  ];
}
