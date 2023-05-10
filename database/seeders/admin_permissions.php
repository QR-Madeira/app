<?php

namespace Database\Seeders;

use App\Classes\PermissionsManager;
use App\Models\User;
use Illuminate\Database\Seeder;

class admin_permissions extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PermissionsManager::grant(User::find(1), PermissionsManager::P_ALL_USER);
    }
}
