<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

/**
 * Dummy migration to close the sequence gap.
 */
class FixMigrationGap extends Migration
{
    public function up()
    {
        // No-op: closes the migration sequence gap.
    }

    public function down()
    {
        // No-op.
    }
}
