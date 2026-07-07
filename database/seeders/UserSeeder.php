<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@consultores-it.pe'],
            [
                'name' => 'Administrador',
                'password' => 'cambiar123',
            ]
        );
    }
}
