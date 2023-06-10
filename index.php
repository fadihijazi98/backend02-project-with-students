<?php

require 'vendor/autoload.php';
header('Content-Type: application/json; charset=utf-8');

use Components\Route;

require 'routes/v1/route.php';
require 'routes/v2/route.php';

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
$response = Route::handleRequest(); // route concept
echo json_encode($response);

