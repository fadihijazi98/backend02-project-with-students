<?php

namespace Components;

use Helpers\RequestHelper;

class Route
{
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

    private static function mapPathWithParams($request_path_parts) {

        foreach (self::$routes as $path => $methodControllers) {
            $exploded_registered_path = explode("/", $path);

            if (sizeof($exploded_registered_path) != sizeof($request_path_parts)) {
                continue;
            }

            $params = [];
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

            echo 'Sorry , there was a problem with your request.';
        }
        elseif (! key_exists($request_method, self::$routes[$request_path])) {

            echo 'Sorry , request is not registered with ' . $request_method . " method";
        }
        else {

            $controller = self::$routes[$request_path][$request_method];
            echo (new $controller())->$request_method(... $request_params);
        }
    }
}

