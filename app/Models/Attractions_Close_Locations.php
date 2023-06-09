<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attractions_Close_Locations extends Model
{
    use HasFactory;

    protected $table = "attractions_close_locations";

    protected $fillable = [
        "belonged_attraction",
        "icon",
        "name",
        "lat",
        "lon",
        "phone",
        "phone_country",
    ];

    public function createPhoneNumber(): string
    {
        return "+$this->phone_country $this->phone";
    }
}
