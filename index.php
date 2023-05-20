<?php

require 'vendor/autoload.php';

use Controllers\LikeController;
use Controllers\CommentController;
use Controllers\UserController;
use Components\Route;

/*
Route::GET("posts/5/comments",CommentController::class);
Route::GET("posts/5/likes",LikeController::class);
Route::POST("posts/5/comments",CommentController::class);
Route::POST("posts/5/likes",LikeController::class);
*/


Route::GET("users",UserController::class);
Route::GET("users/{id}",UserController::class);
Route::POST("users",UserController::class);
Route::PUT("users/{id}",UserController::class);
Route::DELETE("users/{id}",UserController::class);
/*
 * Calling these functions should be here in index.php because .htaccess
 * will return the path which its folder and file doesn't exist
 * to index.php
 */

Route::mapRequestController();
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

/*
 * define response to be always in JSON format (RESTFUL-API)
 */
header('Content-Type: application/json; charset=utf-8');

