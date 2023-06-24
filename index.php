<?php

require 'vendor/autoload.php';
header('Content-Type: application/json; charset=utf-8');

use Illuminate\Database\Capsule\Manager as Capsule;
use Components\Route;

require 'routes/v1/route.php';
require 'routes/v2/route.php';

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

/**
 * what json_encode do ? [covert array to string in JSON format]
 * array:
 * [
 *  'id' => 10,
 *  'name' => 'fadi'
 * ]
 * string
 * '{ "id": 10, "name": "fadi" }'
 */
try {

    $response = Route::handleRequest(); // route concept
}
catch (Exception $e) {

    $response = [
        'message' => $e->getMessage()
    ];

}

echo json_encode($response);


