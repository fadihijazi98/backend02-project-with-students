<?php
namespace Components;


/**
 *
 *
 * Route :: map between Request & Controller
 * Request :: is combination of path & method
 *  GET /users
 *  POST /users
 *
 *  POST /posts/5/comments -> PostController [Route 1]
 *  GET /users -> UserController  [Route 2]
 *
 * static $routes = [
 *      "path" => [
 *          "GET" => "controller",
 *          "POST" => "controller"
 *      ]
 * ]
 *
 * Route::GET("/posts/5/likes", LikeGetController::class) -> Call #1
 * static $routes = [
 *      "/posts/5/likes" => [
 *          "GET" => "LikeController"
 *      ]
 * ]
 *
 *
 * Route::POST("/posts/5/comments", PostController::class) -> Call #2
 * static $routes = [
 *      "/posts/5/likes" => [
 *          "GET" => "UserController"
 *      ],
 *      "/posts/5/comments" => [
 *          "POST" => "PostController"
 *      ]
 * ]
 *
 * Route::POST("posts/5/likes", LikeGetController::class) -> Call #3
 * static $routes = [
 *      "/posts/5/likes" => [
 *          "GET" => "LikeGetController",
 *          "POST" => "LikePostController"
 *      ],
 *      "/posts/5/comments" => [
 *          "POST" => "PostController"
 *      ]
 * ]
 */


class Route {

    /**
     * Request is a path and method.
     * Route is a map between Request & Controller.
     * $routes structure:
     * [
     *      "path" => [
     *          "method" => "controller"
     *      ],
     *      ...
     * ]
     */
    private static $routes;

    public static function GET($path, $controller) {

        self::$routes[$path]["GET"] = $controller;
    }

    public static function POST($path, $controller) {

        self::$routes[$path]["POST"] = $controller;
    }

    public static function mapRequestController() {

        $requestUrl = $_SERVER['REQUEST_URI'];
        $uriParts = explode("/", $requestUrl);

        unset($uriParts[0]);
        unset($uriParts[1]);

        $targetPath = join("/", $uriParts);
        $targetMethod = $_SERVER['REQUEST_METHOD'];

        foreach (self::$routes as $path => $methodControllers) {

            if ($path != $targetPath) {
                continue;
            }

            foreach ($methodControllers as $method => $controller) {

                if ($method == $targetMethod) {

                    echo (new $controller())->index();
                    return;
                }
            }
        }

        echo "request not found";
    }
}