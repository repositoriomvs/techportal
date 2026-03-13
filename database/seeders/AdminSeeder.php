<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        Role::firstOrCreate(['name' => 'tecnico', 'guard_name' => 'web']);

        $admin = User::firstOrCreate(
            ['email' => 'admin@techportal.com'],
            ['name' => 'Administrador', 'password' => bcrypt('Admin2024!')]
        );
        $admin->assignRole('admin');
    }
}
```

Luego en Railway → **Settings** → **Start Command**:
```
php artisan migrate --force && php artisan db:seed --class=AdminSeeder && php artisan serve --host=0.0.0.0 --port=$PORT