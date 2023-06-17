<?php

use Controllers\UserController;
use Components\Route;

Route::setVersion(2);

Route::POST("users/{userId}/posts/{postId}", UserController::class, "like");