<?php

use Components\Route;
use Controllers\LikeController;
use Controllers\CommentController;


Route::setVersion(1);

Route::GET("posts/5/comments",CommentController::class);
Route::GET("posts/5/likes",LikeController::class);
Route::POST("posts/5/comments",CommentController::class);
Route::POST("posts/5/likes",LikeController::class);
