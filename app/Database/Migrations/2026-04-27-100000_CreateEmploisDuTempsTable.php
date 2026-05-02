<?php
namespace App\Database\Migrations;
use CodeIgniter\Database\Migration;

/**
 * Migration : table emplois_du_temps
 * Module 3 - Construction de l'Emploi du Temps
 */
class CreateEmploisDuTempsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'            => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'semaine'       => ['type' => 'DATE'],
            'filiere_id'    => ['type' => 'INT', 'constraint' => 11],
            'cours_id'      => ['type' => 'INT', 'constraint' => 11],
            'enseignant_id' => ['type' => 'INT', 'constraint' => 11],
            'salle_id'      => ['type' => 'INT', 'constraint' => 11],
            'jour'          => [
                'type'       => 'ENUM',
                'constraint' => ['Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi'],
            ],
            'heure_debut'   => ['type' => 'TIME'],
            'heure_fin'     => ['type' => 'TIME'],
            'created_by'    => ['type' => 'INT', 'constraint' => 11, 'null' => true],
            'created_at'    => ['type' => 'DATETIME', 'null' => true],
            'updated_at'    => ['type' => 'DATETIME', 'null' => true],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('filiere_id',    'filieres',    'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('cours_id',      'cours',       'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('enseignant_id', 'enseignants', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('salle_id',      'salles',      'id', 'CASCADE', 'CASCADE');

        $this->forge->createTable('emplois_du_temps');
    }

    public function down()
    {
        $this->forge->dropTable('emplois_du_temps', true);
    }
}