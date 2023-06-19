<?php

use Controllers\UserController;
use Controllers\PostController;
use Components\Route;

Route::setVersion(2);

// POST /api/v2/users/{id}/posts
Route::POST("users/{userId}/posts", PostController::class);

// POST /api/v2/users/{userId}/posts/{postId}
Route::POST("users/{userId}/posts/{postId}", UserController::class, "like");
