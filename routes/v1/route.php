<?php

/**
 * resource: Posts
 * Nested resource ?
 * Is the `post` is existing if the user isn't ?
 * So `post` is completely dependent on `user` resource
 * & from this point, we go out within `nested resource` concept.
 *
 * [Story] CRUD posts
 *      1.a GET /users/{userId}/posts [Nested]
 *      1.b GET /posts/{postId}
 *      2. POST /users/{userId}/posts [Nested]
 *          payload:
 *              {
 *                  "content": string,
 *              }
 *      3. PUT /posts/{postId}
 *      4. DELETE /posts/{postId}
 */
use Controllers\UserController;
use Controllers\PostController;
use Controllers\CommentController;
use Components\Route;

Route::GET("users", UserController::class);
Route::GET("users/{id}", UserController::class, "show");
Route::POST("users", UserController::class);
Route::PUT("users/{id}", UserController::class);
Route::DELETE("users/{id}", UserController::class);

Route::GET("users/{userId}/posts", PostController::class);
Route::GET("posts/{postId}", PostController::class, "show");
Route::POST("users/{userId}/posts", PostController::class);
Route::PUT("posts/{postId}", PostController::class);
Route::DELETE("posts/{postId}", PostController::class);

Route::POST("users/{userId}/posts/{postId}/like", PostController::class, "like");
Route::POST("users/{userId}/posts/{postId}/unlike", PostController::class, "unLike");

Route::PUT("comments/{commentId}", CommentController::class);
Route::POST("users/{userId}/posts/{postId}/comments", CommentController::class);
