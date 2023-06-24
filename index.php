<?php

require 'vendor/autoload.php';
header('Content-Type: application/json; charset=utf-8');

use Components\Route;
require 'routes/v1/route.php';
require 'routes/v2/route.php';

try {

    $response = Route::handleRequest();

} catch (Exception $e){
    $response = [
        'message' => $e->getMessage()
    ];

}
echo json_encode($response);






