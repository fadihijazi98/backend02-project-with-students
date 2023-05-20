<?php

require 'vendor/autoload.php';

use Controllers\UserController;
use Components\Route;

// GET /users/{id}
Route::GET("users/{id}", UserController::class, "show");
// POST /users
Route::POST("users", UserController::class);
// PUT /users/{id}
Route::PUT("users/{id}", UserController::class);
// DELETE /users/{id}
Route::DELETE("users/{id}", UserController::class);

// GET /users/{id}/posts/{id}/comments
Route::GET("users/{id}/posts/{id}/comments", UserController::class);

Route::handleRequest(); // route concept
