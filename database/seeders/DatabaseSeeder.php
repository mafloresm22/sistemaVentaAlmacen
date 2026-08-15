<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Insertar rol Administrador si no existe
        DB::table('roles')->insertOrIgnore([
            ['idRoles' => 1, 'nameRoles' => 'Administrador', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Crear usuario administrador
        User::updateOrCreate(
            ['user' => 'mafloresm01'],
            [
                'name'     => 'Mathias Flores',
                'user'     => 'mafloresm01',
                'email'    => 'mafloresm01@sistema.local',
                'password' => Hash::make('password'),
                'rolesid'  => 1,
            ]
        );
    }
}