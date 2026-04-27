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
            'semaine'       => ['type' => 'DATE'],                 // Lundi de la semaine ex: 2026-04-27
            'filiere_id'    => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'cours_id'      => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'enseignant_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'salle_id'      => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'jour'         => [
                'type'       => 'ENUM',
                'constraint' => ['Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi'],
            ],
            'heure_debut'  => ['type' => 'TIME'],                  // ex: 07:30:00
            'heure_fin'    => ['type' => 'TIME'],                  // ex: 09:30:00
            'created_by'   => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true],
            'created_at'   => ['type' => 'DATETIME', 'null' => true],
            'updated_at'   => ['type' => 'DATETIME', 'null' => true],
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
