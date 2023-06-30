<?php
require 'vendor/autoload.php';
use Illuminate\Database\Capsule\Manager as capsule ;

$capsule = new Capsule;

$capsule->addConnection([
    'driver' => 'mysql',
    'host' => '127.0.0.1',
    'database' => 'backend02-project-with-students',
    'username' => 'root',
    'password' => '',
]);

$capsule->setAsGlobal();
$capsule->bootEloquent();
