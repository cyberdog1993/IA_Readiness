<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $password = env('ADMIN_INITIAL_PASSWORD', 'change-me');

        User::updateOrCreate(
            ['email' => 'admin@consultores-it.pe'],
            [
                'name' => 'Administrador',
                'password' => $password,
            ]
        );
    }
}
