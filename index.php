<?php

require 'vendor/autoload.php';
require "routes/v1/route.php";
require "routes/v2/route.php";

// Defining each request and response to be always in JSON format (RESTFUL-API)
header('Content-Type: application/json; charset=utf-8');

use Components\Route;

try
{
    $response = Route::handleRequest();
}
catch(Exception $exception)
{
    $response =
        [
        'message'=>$exception->getMessage()
        ];
    //To let things clear to the front-end developer, we made exception as $response in json format
}
echo json_encode($response);
//Either $response is normal or is exception, json_encode() will invert it into json format
// We used echo because handleRequest method only return array as value and doesn't print it
/*
 * Calling this function after registering all designed requests
 * in routes array to map every request from client with
 * the required controller to manage it as written logic determines
*/

/*
 * use Dotenv &
 * load environment variables.
 * use `$_ENV` to access variables.
 * (safeLoad) to skip exceptions if `.env` not exist
 */
use Dotenv\Dotenv;
Dotenv::createImmutable(__DIR__)->safeLoad();



