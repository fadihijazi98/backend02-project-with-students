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
     *              "custom_handler" => handler (nullable)
     *          ],
     *      ...
     * ]
     */
    private static $routes;

    private static $version = 1;

    private static function register($path, $method, $controller, $custom_handler) {

        $path = "api/v" . self::$version . "/" . $path;

        self::$routes[$path][$method]["controller"] = $controller;
        self::$routes[$path][$method]["custom_handler"] = $custom_handler;
    }

    /**
     * This is method associated to add `api/v*` to all registered requests.
     * Make sure to passing an integer and none null value when you are use this method.
     *
     * @param integer $version_number
     * @return void
     * @throws \Exception when `$version_number` is null or none integer.
     */
    public static function setVersion($version_number) {

        if ($version_number == null || !is_integer($version_number)) {

            throw new \Exception("[Bad use] Version number can not be null or none integer");
        }
        self::$version = $version_number;
    }

    public static function GET($path, $controller, $custom_handler = null) {

        self::register($path, "GET", $controller, $custom_handler);
    }

    public static function POST($path, $controller, $custom_handler = null) {

        self::register($path, "POST", $controller, $custom_handler);
    }

    public static function PUT($path, $controller, $custom_handler = null) {

        self::register($path, "PUT", $controller, $custom_handler);
    }

    public static function DELETE($path, $controller, $custom_handler = null) {

        self::register($path, "DELETE", $controller, $custom_handler);
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

                    $param_key = substr($item, 1, strlen($item) - 2);
                    $params[$param_key] = $request_path_parts[$index];

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

        $uri = RequestHelper::getUriWithoutQueryParams($_SERVER['REQUEST_URI']);

        $path_parts = RequestHelper::getRequestUriAsArray($uri, true);
        $mapped_path_params = self::mapPathWithParams($path_parts);

        $request_path = $mapped_path_params['path'];
        $request_params = $mapped_path_params['params'];
        $request_method = $_SERVER['REQUEST_METHOD'];

        if (! $request_path) {

            return ["message" => "request is not found."];
        }
        elseif (! key_exists($request_method, self::$routes[$request_path])) {

            return ["message" => "request isn't registered with " . $request_method . " method"];
        }
        else {

            $controller = self::$routes[$request_path][$request_method]["controller"];
            $custom_handler = self::$routes[$request_path][$request_method]["custom_handler"];

            if ($custom_handler != null) {

                $request_method = $custom_handler;
            }

            /** @var array $request_params */
            return (new $controller())->$request_method($request_params);
        }
    }
}