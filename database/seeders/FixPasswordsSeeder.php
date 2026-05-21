<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;

class FixPasswordsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $usuarios = Usuario::all();
        $count = 0;

        foreach ($usuarios as $usuario) {
            // Un hash de Bcrypt siempre empieza con $2y$ o $2a$ y tiene 60 caracteres
            // Si no empieza así, lo encriptamos
            if (!str_starts_with($usuario->contrasena, '$2y$') && !str_starts_with($usuario->contrasena, '$2a$')) {
                $usuario->contrasena = Hash::make($usuario->contrasena);
                $usuario->save();
                $count++;
            }
        }

        $this->command->info("Se han encriptado {$count} contraseñas.");
    }
}
