<?php
namespace App\Database\Migrations;
use CodeIgniter\Database\Migration;

class CreateFilieresTable extends Migration {
    public function up() {
        $this->forge->addField([
            'id'         => ['type' => 'INT', 'auto_increment' => true],
            'nom'        => ['type' => 'VARCHAR', 'constraint' => 100],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('filieres');
    }

    public function down() {
        $this->forge->dropTable('filieres');
    }
}