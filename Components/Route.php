<?php

namespace Components;


class Route
{
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