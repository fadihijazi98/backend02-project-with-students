<?php

require 'vendor/autoload.php';
use Illuminate\Database\Capsule\Manager as Capsule;

/**
 * setup database dependencies
 */
$capsule = new Capsule();
$capsule->addConnection([
    'driver' => 'mysql',
    'host' => '127.0.0.1',
    'database' => 'backend-with-students-facebook-project-01',
    'username' => 'root',
    'password' => '123456789',
]);

$capsule->setAsGlobal();
$capsule->bootEloquent();

