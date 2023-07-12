<?php

header('Content-Type:application/json; charset=utf-8');

require 'vendor/autoload.php';

/** setup database dependencies */

require "bootstrap.php";

/** require routes for several versions */

require "routes/v1/route.php";
/*require "routes/v2/route.php";*/


use Controller\CommentsController;
use Controller\LikesController;
use component\Route;

/*$users=\Models\User::all();*/

try {
$response=Route::handelRequest();
echo json_encode($response);


} catch (Exception $e) {
    // Exception handling code
    echo "Exception : " . $e->getMessage();

}


