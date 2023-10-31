<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use App\Models\Usuarios\Roles;

class RolSeeder extends Seeder
{
    public function run()
    {
        $sm = new Roles();

        // Array de roles
        $roles = [
            [
                'nombre' => 'Super Administrador',
            ],
            [
                'nombre' => 'Administrador',
            ],
            [
                'nombre' => 'Usuario',
            ],
        ];

        // Using Query Builder
        $sm->insertBatch($roles);
        
    }
}
