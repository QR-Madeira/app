<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
    use HasFactory;

    protected $table = 'attractions';

    protected $fillable = [
        'name',
        'email',
        'password',
        'created_by'
    ];
}
