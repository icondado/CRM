<?php

namespace Database\Seeders;

use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'nombre'         => 'Admin01',
                'apellidos'      => 'Principal',
                'dni'            => '12345678A',
                'direccion'      => 'Calle Falsa 123',
                'codigo_postal'  => '28080',
                'provincia'      => 'Madrid',
                'telefono'       => '600000001',
                'email'          => 'admin01@example.com',
                'password'       => Hash::make('123456789'),
                'permisos'       => 0,
                'activo'         => 1,
                'fecha_alta'     => Carbon::now()->format('Y-m-d'),
                'foto'           => 'admin.jpg',
            ],
            [
                'nombre'         => 'User01',
                'apellidos'      => 'Ejemplo',
                'dni'            => '87654321B',
                'direccion'      => 'Avenida Siempre Viva 742',
                'codigo_postal'  => '46001',
                'provincia'      => 'Valencia',
                'telefono'       => '600000002',
                'email'          => 'users01@example.com',
                'password'       => Hash::make('123456789'),
                'permisos'       => 1,
                'activo'         => 1,
                'fecha_alta'     => Carbon::now()->format('Y-m-d'),
                'foto'           => 'usuario.png',
            ],
        ]);
    }
}
