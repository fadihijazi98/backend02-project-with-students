<?php

/**
 * DOC:
 * Supposed that we have all create tables (as migrations) in migrations/ directory
 * each file have a convention name: {{date:'YYYY-MM-DD-HH-MM-SS'}}.{{tableName:snack_case}}.table.php
 * example: the script name that creates users table should be like: 2023_06_26_02_12_00.users.table.php
 */
require "bootstrap.php";

use Illuminate\Database\Capsule\Manager;

$migrations = glob(__DIR__ . "/migrations/*");

foreach ($migrations as $migration) {

    $_ = explode("/", $migration);
    $scriptName = array_pop($_);

    $tableName = explode(".", $scriptName)[1];
    if (Manager::schema()->hasTable($tableName)) {

        echo "[SKIPPED] $tableName table already existing \n";
        continue;
    }

    require $migration;
    echo "$tableName has been created \n";
}
