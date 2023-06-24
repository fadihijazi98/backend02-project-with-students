<?php

use Components\Route;
use Controllers\PostController;
use Controllers\UserController;


Route::setVersion(2);
Route::GET("users/{user_id}/posts/{post_id}/comments",UserController::class);
Route::GET("users",UserController::class);
Route::GET("users/{user_id}",UserController::class);
Route::POST("users",UserController::class);
Route::PUT("users/{user_id}",UserController::class);
Route::DELETE("users/{user_id}",UserController::class);
Route::POST("users/{user_id}/posts", PostController::class);