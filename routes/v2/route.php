<?php

use Controllers\UserController;
use Controllers\PostController;
use Components\Route;

Route::setVersion(2);

Route::POST("users/{userId}/posts/{postId}", UserController::class, "like");
Route::POST("users/{userId}/posts",PostController::class);