<?php

use Controllers\LikeController;
use Controllers\CommentController;
use Components\Route;

Route::setVersion(1);

Route::GET("posts/5/comments",CommentController::class);
Route::GET("posts/5/likes",LikeController::class);
Route::POST("posts/5/comments",CommentController::class);
Route::POST("posts/5/likes",LikeController::class);

/*
 * Calling these functions should be here in index.php because .htaccess
 * will return the path which its folder and file doesn't exist
 * to index.php,but after that we moved it into versions so it
 * shouldn't be in index.php
 */