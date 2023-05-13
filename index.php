<?php


require 'vendor/autoload.php';

use Controllers\CommentController;
use Controllers\LikeGetController;
use \Controllers\LikePostController;

use Components\Route;


Route::GET("posts/5/likes", LikeGetController::class);
Route::POST("posts/5/comments", CommentController::class);
Route::POST("posts/5/likes", LikePostController::class);

Route::mapRequestController(); // route concept