<?php

require 'bootstrap.php';
header('Content-Type: application/json; charset=utf-8');

use Components\Route;
use Constants\StatusCodes;

require 'routes/v1/route.php';

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

    $response = Route::handleRequest();
    $code = StatusCodes::SUCCESS;
}
catch (Exception $exception) {

    $response = [
        'error' => $exception->getMessage()
    ];
    $code = $exception->getCode() == 0 ? StatusCodes::SERVER_ERROR : $exception->getCode();
}

http_response_code($code);
echo json_encode($response);


