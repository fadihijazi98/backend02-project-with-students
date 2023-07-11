<?php

header('Content-Type:application/json; charset=utf-8');

require 'vendor/autoload.php';

/*
 * require routes for several versions
 * */

require "routes/v1/route.php";
/*require "routes/v2/route.php";*/


use Controller\CommentsController;
use Controller\LikesController;
use component\Route;
use Illuminate\Database\Capsule\Manager as Capsule;

/**
 * setup database dependencies
 * */
$capsule = new Capsule;

$capsule->addConnection([
    'driver' => 'mysql',
    'host' => '127.0.0.1',
    'database' => 'Facebook-API',
    'username' => 'root',
    'password' => '',
    'charset' => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix' => '',
]);

$capsule->setAsGlobal();
$capsule->bootEloquent();

/*$users=\Models\User::all();*/

try {
$response=Route::handelRequest();
echo json_encode($response);


} catch (Exception $e) {
    // Exception handling code
    echo "Exception : " . $e->getMessage();

}


