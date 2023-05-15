<?php

require 'vendor/autoload.php';

use Controllers\CommentController;
use Controllers\LikeGetController;
use Controllers\LikePostController;
use Components\Route;

Route::GET('posts/5/comments',CommentController::class);
Route::GET("posts/5/Likes",LikeGetController::class);
Route::POST("posts/5/Likes",LikePostController::class);

Route::mapRequestController();
