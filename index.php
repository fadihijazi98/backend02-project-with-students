<?php
// require 'vendor/autoload.php';
// /*
//  * use Dotenv &
//  * load environment variables.
//  * use `$_ENV` to access variables.
//  * (safeLoad) to skip exceptions if `.env` not exist
//  */
// use Dotenv\Dotenv;
// Dotenv::createImmutable(__DIR__)->safeLoad();

// /*
//  * define response to be always in JSON format (RESTFUL-API)
//  */
// header('Content-Type: application/json; charset=utf-8');
require 'vendor/autoload.php';
//require 'controllers/CommentsController.php';
//require 'controllers/LikesController.php';

use Component\Route;
use Controller\CommentsController;
use Controller\LikesController;
// echo "helloooo!<br />";
// $uri=$_SERVER['REQUEST_URI'];
// $uriParts=explode("/",$uri);
// //var_dump($uriParts);
// echo "<br />";
// unset($uriParts[0]);
// unset($uriParts[1]);
// $path=join("/",$uriParts);
// Route::GET($path);
//var_dump($path);

// if($path == "posts/5/comments"){
//     echo CommentsController::show();
// }
// else if($path == "posts/5/likes"){
//     echo LikesController::show();
// }

Route::GET("posts/5/comments",CommentsController::class);
Route::POST("posts/5/likes",LikesController::class);
//var_dump(Route::viewRequists());

Route::requistsControllersMapper();




