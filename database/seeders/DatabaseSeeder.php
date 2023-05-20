<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Classes\PasswordHash;
use const App\Auth\P_ALL;
//use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    protected $hash;
    public function run(): void
    {
        $hash = new PasswordHash(8, FALSE); 
        DB::table("users")->insert([
            "id" => 1,
            "name" => "Administrator",
            "email" => env("DEFAULT_ADMIN_EMAIL"),
            "password" => $hash->HashPassword(env("DEFAULT_ADMIN_PASSWORD")),
            //"password" => Hash::make(env("DEFAULT_ADMIN_PASSWORD")),
            "permissions" => P_ALL,
            "super" => true,
        ]);
    }
}
