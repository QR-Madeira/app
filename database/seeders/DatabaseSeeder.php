<?php

namespace Database\Seeders;

use App\Classes\PasswordHash;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use const App\Auth\P_ALL;

class DatabaseSeeder extends Seeder
{
    protected $hash;
    public function run(): void
    {
        $hash = new PasswordHash(10, FALSE);
        DB::table("users")->insert([
            "id" => 1,
            "name" => "Administrator",
            "email" => env("DEFAULT_ADMIN_EMAIL"),
            "password" => $hash->HashPassword(env("DEFAULT_ADMIN_PASSWORD")),
            //"password" => Hash::make(env("DEFAULT_ADMIN_PASSWORD")),
            "permissions" => P_ALL,
            "super" => true,
            "active" => true,
        ]);
    }
}
