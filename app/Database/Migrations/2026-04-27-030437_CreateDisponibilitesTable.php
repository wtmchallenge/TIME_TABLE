<?php
namespace App\Database\Migrations;
use CodeIgniter\Database\Migration;

class CreateDisponibilitesTable extends Migration {
    public function up() {
        $this->forge->addField([
            'id'             => ['type' => 'INT', 'auto_increment' => true],
            'enseignant_id'  => ['type' => 'INT'],
            'jour'           => ['type' => 'ENUM', 
                                 'constraint' => ['Lundi','Mardi','Mercredi',
                                                  'Jeudi','Vendredi','Samedi']],
            'heure_debut'    => ['type' => 'TIME'],
            'heure_fin'      => ['type' => 'TIME'],
            'created_at'     => ['type' => 'DATETIME', 'null' => true],
            'updated_at'     => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('enseignant_id', 'enseignants', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('disponibilites');
    }

    public function down() {
        $this->forge->dropTable('disponibilites');
    }
}