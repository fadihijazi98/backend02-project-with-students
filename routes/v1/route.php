<?php

namespace routes;

use component\Route;
use Controller\UserController;
use http\Client\Curl\User;

Route::setVersion(1);

// CRUD operation ->  create , read , delete , update operation

Route::GET('users',UserController::class);
Route::GET("users/{id}",UserController::class,"show");
Route::POST("users",UserController::class);
Route::PUT("users/{id}",UserController::class);
Route::DELETE("users/{id}",UserController::class);