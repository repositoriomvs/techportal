<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\User;

class RolesSeeder extends Seeder
{
    public function run(): void
    {
        // Crear roles
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'tecnico']);

        // Asignar rol admin al primer usuario
        $admin = User::first();
        if ($admin) {
            $admin->assignRole('admin');
        }
    }
}