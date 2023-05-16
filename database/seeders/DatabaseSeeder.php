<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

use const App\Auth\P_ALL;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        DB::table("users")->insert([
            "id" => 1,
            "name" => "Administrator",
            "email" => env("DEFAULT_ADMIN_EMAIL"),
            "password" => Hash::make(env("DEFAULT_ADMIN_PASSWORD")),
            "permissions" => P_ALL,
            "super" => true,
        ]);
    }
}
