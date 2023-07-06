<?php

namespace routes;

use component\Route;
use Controller\UserController;

Route::setVersion(1);

// CRUD operation ->  create , read , delete , update operation
Route::GET("user/{id}/comment/{id}/post", UserController::class);

Route::GET("users", UserController::class);
Route::GET("users/{id}", UserController::class, "show");
Route::POST("users", UserController::class);
Route::PUT("users/{id}", UserController::class);
Route::DELETE("users/{id}", UserController::class);
