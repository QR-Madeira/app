<?php

/**
 * @package App\\Models
 * @author João Augusto Costa Branco Marado Torres <torres.dev@disroot.org>
 * @copyright Copyright (C) 2023  Danilo Kymhyr, João Torres, Leonardo Abreu de Paulo
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

final class AttractionDescriptions extends Model
{
    use HasFactory;

    protected $table = "attraction_descriptions";

    protected $fillable = [
        "description",
        "language",
        "attraction_id",
    ];
}
