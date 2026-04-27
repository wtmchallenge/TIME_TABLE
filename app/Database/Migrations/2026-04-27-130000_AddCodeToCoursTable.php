<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddCodeToCoursTable extends Migration
{
    public function up()
    {
        $fields = [
            'code' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => true,
                'after'      => 'volume_horaire',
            ],
        ];
        $this->forge->addColumn('cours', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('cours', 'code');
    }
}

