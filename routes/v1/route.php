<?php

use Controllers\userController;
use Components\Route;
use Controllers\PostController;

Route::GET("users", UserController::class);
Route::GET("users/{id}", UserController::class, "show");
Route::POST("users", UserController::class);
Route::PUT("users/{id}", UserController::class);
Route::DELETE("users/{id}", UserController::class);

Route::GET("users/{userId}/posts",PostController::class);
Route::GET("posts/{postId}",PostController::class,"show");

Route::POST("users/{userId}/posts",PostController::class);
Route::PUT("posts/{postId}",PostController::class);
Route::DELETE("posts/{postId}",PostController::class);
