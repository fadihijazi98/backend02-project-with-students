<?php

use Controllers\UserController;
use Controllers\PostController;
use Components\Route;

try
{
    Route::setVersion(2);
}
catch (Exception $e)
{

}

Route::GET("users/{id}/posts/{id}/comments",UserController::class);
Route::POST("users/{id}/posts",PostController::class);
Route::GET("users",UserController::class);
Route::GET("users/{id}",UserController::class);
Route::POST("users",UserController::class);
Route::PUT("users/{id}",UserController::class);
Route::DELETE("users/{id}",UserController::class);

/*
 * Calling these functions should be here in index.php because .htaccess
 * will return the path which its folder and file doesn't exist
 * to index.php,but after that we moved it into versions so it
 * shouldn't be in index.php
 */