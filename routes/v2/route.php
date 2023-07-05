<?php



namespace routes;
use component\Route;
use Controller\UserController;

Route::setVersion(2);

// CRUD operation ->  create , read , delete , update operation
Route::GET("user/{id}/comment/{id}/post", UserController::class);

Route::GET("users", UserController::class);
Route::GET("users/{id}", UserController::class,"like");
Route::POST("users", UserController::class);
Route::PUT("users/{id}", UserController::class);
Route::DELETE("users/{id}", UserController::class);


