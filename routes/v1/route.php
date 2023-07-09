<?php

namespace routes;

use component\Route;
use Controller\UserController;

Route::setVersion(1);

// CRUD operation ->  create , read , delete , update operation
Route::GET("user/{userId}/comment/{postId}/post", UserController::class,"show");

Route::GET("users/{id}", UserController::class);
Route::POST("users/", UserController::class);
Route::PUT("users/{id}", UserController::class);
Route::DELETE("users/{id}", UserController::class);
