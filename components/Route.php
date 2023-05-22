<?php
namespace Components;

use Helpers\RequestHelper;
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
 *          "POST" => "controller",
 *          "PUT" => "controller",
 *          "DELETE" => "controller"
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
 *      "users" => [
 *          "GET" => "UserController",
 *          "CREATE" => "UserController"
 *      ],
 *      "users/{id}" => [
 *          "GET" => "UserController",
 *          "PUT" => "UserController",
 *          "DELETE" => "UserController"
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
     *          "method" => [
     *              "controller" => controller,
     *              "custom_handler" => handler
     *          ]
     *      ],
     *      ...
     * ]
     */
    private static $routes;

    private static function register($path, $method, $controller) {

        self::$routes[$path][$method] = $controller;
    }

    public static function GET($path, $controller) {

        self::register($path, "GET", $controller);
    }

    public static function POST($path, $controller) {

        self::register($path, "POST", $controller);
    }

    public static function PUT($path, $controller) {

        self::register($path, "PUT", $controller);
    }

    public static function DELETE($path, $controller) {

        self::register($path, "DELETE", $controller);
    }

    /**
     * the returned value structured is always like
     *  [
     *      'path' => string,
     *      'params' => string[]
     *  ]
     *
     * @param string[] $request_path_parts
     * @return string[]
     */
    private static function mapPathWithParams($request_path_parts) {

        foreach (self::$routes as $path => $methodControllers) {

            /**
             * GET /users/3/posts/1090/comments
             *
             * path = "/users/{id}/posts/{id}/comments" (reference)
             * request_path = "/users/3/posts/1090/comments" (.*check)
             * request_method = "GET"
             */
            // $path = users/{id}/posts/{id}/comments
            // $request_path = users/3/posts/1090/comments

            $exploded_registered_path = explode("/", $path); // ["users", "{id}", "posts", "{id}", "comments"]
            // $request_path_parts is ["users", "3", "posts", "1090", "likes"]


            if (sizeof($exploded_registered_path) != sizeof($request_path_parts)) {
                continue;
            }

            $params = []; // [3, 1090]
            $isMatch = true;

            foreach($exploded_registered_path as $index => $item) {

                if (str_starts_with($item, "{") && str_ends_with($item, "}"))
                {

                    $params[] = $request_path_parts[$index];
                    continue;
                }
                if ($item != $request_path_parts[$index])
                {

                    $isMatch = false;
                    break;
                }
            }

            if ($isMatch) {

                return [
                    'path' => $path,
                    'params' => $params
                ];
            }
        }

        return [
            'path' => '',
            'params' => ''
        ];
    }

    public static function handleRequest() {

        $path_parts = RequestHelper::getRequestUriAsArray(true);
        $mapped_path_params = self::mapPathWithParams($path_parts);

        $request_path = $mapped_path_params['path'];
        $request_params = $mapped_path_params['params'];
        $request_method = $_SERVER['REQUEST_METHOD'];

        if (! $request_path) {

            echo "request is not found.";
        }
        elseif (! key_exists($request_method, self::$routes[$request_path])) {

            echo "request isn't registered with " . $request_method . " method";
        }
        else {

            $controller = self::$routes[$request_path][$request_method];

            /** @var array $request_params */
            echo (new $controller())->$request_method(... $request_params);
        }
    }
}