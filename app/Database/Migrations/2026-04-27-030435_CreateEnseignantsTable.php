<?php
namespace App\Database\Migrations;
use CodeIgniter\Database\Migration;

class CreateEnseignantsTable extends Migration {
    public function up() {
        $this->forge->addField([
            'id'         => ['type' => 'INT', 'auto_increment' => true],
            'nom'        => ['type' => 'VARCHAR', 'constraint' => 100],
            'prenom'     => ['type' => 'VARCHAR', 'constraint' => 100],
            'email'      => ['type' => 'VARCHAR', 'constraint' => 150],
            'specialite' => ['type' => 'VARCHAR', 'constraint' => 150],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('enseignants');
    }

    public function down() {
        $this->forge->dropTable('enseignants');
    }
}