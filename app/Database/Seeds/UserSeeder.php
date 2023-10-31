<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $us = new \App\Models\Usuarios\Usuarios();

        // Array de usuarios
        $usuarios = [
            [
                'nombre' => 'Super',
                'apellido' => 'Administrador',
                'email' => 'superadmin@geoshglobal.com',
                'password' => password_hash('@Dyj21278370', PASSWORD_DEFAULT),
            ],
            [
                'nombre' => 'Administrador',
                'apellido' => 'Administrador',
                'email' => 'admin@geoshglobal.com',
                'password' => password_hash('@AdminGg2023', PASSWORD_DEFAULT),
            ],
            [
                'nombre' => 'Usuario',
                'apellido' => 'Usuario',
                'email' => 'user@geoshglobal.com',
                'password' => password_hash('12345', PASSWORD_DEFAULT),
            ],

        ];

        // Using Query Builder
        $us->insertBatch($usuarios);

        // Establece roles para cada usuario del array
        $this->db->table('usuarios')->set('role_id', 1)->where('email', 'superadmin@geoshglobal.com')->update();
        $this->db->table('usuarios')->set('role_id', 2)->where('email', 'admin@geoshglobal.com')->update();
        $this->db->table('usuarios')->set('role_id', 3)->where('email', 'user@geoshglobal.com')->update();


    }
}
