<?php

require 'vendor/autoload.php';

use Controllers\userController;
use Components\Route;

Route::GET("users/{id}", UserController::class, "show");
Route::POST("users", UserController::class);
Route::PUT("users/{id}", UserController::class);
Route::DELETE("users/{id}", UserController::class);
Route::GET("users/{id}/posts/{id}/comments", UserController::class);

Route::handleRequest();





/*
* static $routes = [
      "users" => [
          "GET" => userController
          "POST" => userController
      ],
     "users/{id}" => [
         "GET" => userController
         "PUT" => userController
         "DELETE" => userController
    ]
];

 */

