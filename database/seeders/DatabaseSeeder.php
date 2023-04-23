<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        DB::table("users")->insert([
            "id" => 1,
            "name" => "Administrator",
            "email" => "admni@localhost",
            "password" => password_hash("!passwdS3cr3t3", PASSWORD_BCRYPT),
        ]);
    }
}
