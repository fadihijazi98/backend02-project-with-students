<?php

use Controllers\userController;
use Components\Route;
use Controllers\PostController;

Route::GET("users", UserController::class);
Route::GET("users/{id}", UserController::class, "show");
Route::POST("users", UserController::class);
Route::PUT("users/{id}", UserController::class);
Route::DELETE("users/{id}", UserController::class);
