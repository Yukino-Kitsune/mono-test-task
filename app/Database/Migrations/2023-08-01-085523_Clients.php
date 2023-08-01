<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Clients extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'client_id' => [
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true
            ],
            'full_name' => [
                'type' => 'VARCHAR',
                'constraint' => 32,
            ],
            'phone' => [
                'type' => 'VARCHAR',
                'constraint' => 11,
                'unique' => true
            ],
            'address' => [
                'type' => 'VARCHAR',
                'constraint' => 64
            ]
        ]);
        $this->forge->addKey('client_id', true);
        $this->forge->createTable('clients');
    }

    public function down()
    {
        $this->forge->dropTable('clients');
    }
}
