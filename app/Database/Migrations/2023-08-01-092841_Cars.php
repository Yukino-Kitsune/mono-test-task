<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Cars extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'car_id' => [
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true
            ],
            'brand' => [
                'type' => 'VARCHAR',
                'constraint' => 32,
            ],
            'model' => [
                'type' => 'VARCHAR',
                'constraint' => 32
            ],
            'color' => [
                'type' => 'VARCHAR',
                'constraint' => 32
            ],
            'plate_number' => [
                'type' => 'VARCHAR',
                'constraint' => 8,
                'unique' => true
            ],
            'parked' => [
                'type' => 'BOOLEAN'
            ],
            'owner_id' => [
                'type' => 'INT',
                'unsigned' => true
            ]
        ]);
        $this->forge->addKey('car_id', true);
        $this->forge->addForeignKey('owner_id', 'clients', 'client_id');
        $this->forge->createTable('cars');
    }

    public function down()
    {
        $this->forge->dropTable('cars');
    }
}
