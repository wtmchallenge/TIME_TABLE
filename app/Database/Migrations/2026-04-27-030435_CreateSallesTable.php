<?php
namespace App\Database\Migrations;
use CodeIgniter\Database\Migration;

class CreateSallesTable extends Migration {
    public function up() {
        $this->forge->addField([
            'id'         => ['type' => 'INT', 'auto_increment' => true],
            'nom'        => ['type' => 'VARCHAR', 'constraint' => 100],
            'capacite'   => ['type' => 'INT'],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('salles');
    }

    public function down() {
        $this->forge->dropTable('salles');
    }
}