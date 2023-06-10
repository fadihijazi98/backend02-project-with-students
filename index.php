<?php

require 'vendor/autoload.php';

use Controllers\UserController;
use Components\Route;

// GET /users
Route::GET("users", UserController::class);
// GET /users/{id}
Route::GET("users/{id}", UserController::class, "show");
// POST /users
Route::POST("users", UserController::class);
// POST /users/{userId}/posts/{postId}
Route::POST("users/{userId}/posts/{postId}", UserController::class, "like");
// PUT /users/{id}
Route::PUT("users/{id}", UserController::class);
// DELETE /users/{id}
Route::DELETE("users/{id}", UserController::class);

// GET /users/{id}/posts/{id}/comments
Route::GET("users/{id}/posts/{id}/comments", UserController::class);

Route::handleRequest(); // route concept
