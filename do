<?php

use Engine\Console\Console;
use Engine\Console\Logger;

require_once __DIR__ . '/vendor/autoload.php';

Console::run($argv);
/*
$table = [
    [
        'name' => 'id',
        'type' => 'int',
        'length' => 11,
        'auto_increment' => false,
        'primary' => true,
    ],
    [
        'name' => 'name',
        'type' => 'string',
        'length' => 255,
        'auto_increment' => false,
        'primary' => false,
    ],
    [
        'name' => 'email',
        'type' => 'string',
        'length' => 255,
        'auto_increment' => false,
        'primary' => false,
    ],
    [
        'name' => 'password',
        'type' => 'string',
        'length' => 255,
        'auto_increment' => false,
        'primary' => false,
    ],
    [
        'name' => 'created_at',
        'type' => 'datetime',
        'length' => false,
        'auto_increment' => false,
        'primary' => false,
    ],
    [
        'name' => 'updated_at',
        'type' => 'datetime',
        'length' => false,
        'auto_increment' => false,
        'primary' => false,
    ],
];

Logger::table($table, true);
*/