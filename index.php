<?php


require 'vendor/autoload.php';
header('Content-Type:application/json; charset=utf-8');
use Controller\CommentsController;
use Controller\LikesController;
use component\Route;
require "routes/v1/route.php";
/*require "routes/v2/route.php";*/


try {
$response=Route::handelRequest();
echo json_encode($response);


} catch (Exception $e) {
    // Exception handling code
    echo "Exception : " . $e->getMessage();

}


