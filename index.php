<?php

require 'vendor/autoload.php';
header('Content-Type: application/json; charset=utf-8');

use Components\Route;
require 'routes/v1/route.php';
require 'routes/v2/route.php';

$response=Route::handleRequest();
echo json_encode($response);






