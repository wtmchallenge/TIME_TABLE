<?php
namespace App\Database\Migrations;
use CodeIgniter\Database\Migration;

class CreateCoursTable extends Migration {
    public function up() {
        $this->forge->addField([
            'id'             => ['type' => 'INT', 'auto_increment' => true],
            'intitule'       => ['type' => 'VARCHAR', 'constraint' => 150],
            'filiere_id'     => ['type' => 'INT'],           // lien vers filieres
            'volume_horaire' => ['type' => 'INT'],           // en heures
            'code'           => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'created_at'     => ['type' => 'DATETIME', 'null' => true],
            'updated_at'     => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('filiere_id', 'filieres', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('cours');
    }

    public function down() {
        $this->forge->dropTable('cours');
    }
}
