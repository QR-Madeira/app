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
        DB::table("site_info")->insert([
            "id" => 1,
            "title" => "QR-Madeira",
            "footerSede" => "[Freguesia], [Cidade], [Regiao], [Codigo Postal]",
            "footerPhone" => "[Nº de Telefone]",
            "footerMail" => "[Correio eletrônico]",
            "footerCopyright" => "2023 QR-Madeira-Funchal.",
        ]);
        DB::table("site_descriptions")->insert([
            "description" => "QR-Madeira is a cutting-edge online platform that revolutionizes the way visitors explore the enchanting island of Madeira. As the go-to destination for tourists and locals alike, this dynamic website offers a seamless and interactive experience that unlocks a wealth of information, attractions, and hidden gems through the power of QR codes.",
            "language" => "en",
            "site_id" => 1
        ]);
    }
}
