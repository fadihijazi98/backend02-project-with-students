<?php
use Controllers\UserController;
use Components\Route;

Route::setVersion(1);

// GET /users
Route::GET("users", UserController::class);
// GET /users/{id}
Route::GET("users/{id}", UserController::class, "show");
// POST /users
Route::POST("users", UserController::class);
// PUT /users/{id}
Route::PUT("users/{id}", UserController::class);
// DELETE /users/{id}
Route::DELETE("users/{id}", UserController::class);

