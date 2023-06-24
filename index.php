<?php

use Components\Route;

require 'vendor/autoload.php';
//require "routes/v1/route.php";
require "routes/v2/route.php";


header('Content-Type: application/json; charset=utf-8');


try {

    $response = Route::handleRequest();
}
catch (Exception $e) {

    $response = [
        'message' => $e->getMessage()
    ];

}
echo json_encode($response);

