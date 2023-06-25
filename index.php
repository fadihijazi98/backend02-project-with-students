<?php

require 'vendor/autoload.php';
header('Content-Type: application/json; charset=utf-8');

use Illuminate\Database\Capsule\Manager as Capsule;
use Components\Route;

require 'routes/v1/route.php';
require 'routes/v2/route.php';


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

$users =\Model\User::all();
var_dump($users);die();

try {

    $response = Route::handleRequest();

} catch (Exception $e) {
    $response = [
        'message' => $e->getMessage()
    ];

}
echo json_encode($response);






