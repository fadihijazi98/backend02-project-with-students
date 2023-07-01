<?php

require "bootstrap.php";

use Illuminate\Database\Capsule\Manager;

$migrations = glob(__DIR__ . "/migrations/*");

foreach ($migrations as $migration)
{
    $wholeNameOfScript = explode("/", $migration);

    $scriptName = array_pop($wholeNameOfScript);

    $tableName = explode(".", $scriptName)[1];

    if (Manager::schema()->hasTable($tableName))
    {
        echo "$tableName table is already exist!! \n";
        continue;
    }

    require $migration;

    echo "$tableName has been created \n";
}
