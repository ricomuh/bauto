<?php

namespace App\Database\Migrations;

use Engine\Migration\Column;
use Engine\Migration\Migrator;

class Migration extends Migrator
{
    public function run()
    {
        $this->table('users', function (Column $column) {
            $column->id();
            $column->string('name');
            $column->string('email');
            $column->string('password');
            $column->timestamps();
        });
    }
}
