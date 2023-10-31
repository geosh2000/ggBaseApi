<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class LogMigration extends Migration
{
    public function up()
    {
        // Crea una tabla de registros de login y logout
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
                'comment' => 'ID del registro',
            ],
            'usuario_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'comment' => 'ID del usuario',
            ],
            'ip' => [
                'type' => 'VARCHAR',
                'constraint' => 45,
                'comment' => 'IP del usuario',
            ],
            'user_agent' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'comment' => 'User Agent del usuario',
            ],
            'fecha' => [
                'type' => 'DATETIME',
                'comment' => 'Fecha del registro',
            ],
            'accion' => [
                'type' => 'ENUM',
                'constraint' => ['login', 'logout'],
                'default' => 'login',
                'comment' => 'Acción del registro',
            ],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('usuario_id', 'usuarios', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('user_logs');

    }

    public function down()
    {
        $this->forge->dropTable('user_logs');
    }
}
