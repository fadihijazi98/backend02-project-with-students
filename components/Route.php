<?php

namespace Components;

class Route
{

    private static array $routes = [];

     // It will be the container for all routes that user will ask to get in

    public static function register($path,$method,$controller): void
    {
        self::$routes[$path][$method] = $controller;
        /*
         * This function is required because in future the structure of
         * routes array may be changed, so it will reduce positions of change
         * and it will be the reference for all routes
         */
    }

    public static function GET($path, $controller): void
    {

        self::register($path,"GET",$controller);
        /*
         * This function will register the requests that are manipulated
         * by GET method with the specified controller to handle it
         */
    }

    public static function POST($path, $controller): void
    {

        self::register($path,"POST",$controller);
        /*
         * This function will register the requests that are manipulated
         * by POST method with the specified controller to handle it
         */
    }

    public static function PUT($path,$controller): void
    {
        self::register($path,"PUT",$controller);
        /*
         * This function will register the requests that are manipulated
         * by PUT method with the specified controller to handle it
         */
    }

    public static function DELETE($path,$controller): void
    {
        self::register($path,"DELETE",$controller);
        /*
         * This function will register the requests that are manipulated
         * by DELETE method with the specified controller to handle it
         */
    }

    public static function mapRequestController(): void
    {
        /*
         * 1.This function will receive the full URL, so we wrote the cutting
         * algorithm to only get the signature of the API or request
         *
         * 2.This function will map between the request (path) and the required
         * controller to manage it so that client get the wanted results of the
         * wanted API
         */

        $requestURI = $_SERVER['REQUEST_URI'];
        $uriParts = explode("/", $requestURI);

        unset($uriParts[0]);
        unset($uriParts[1]);

        $targetPath = join("/", $uriParts);
        $targetMethod = $_SERVER['REQUEST_METHOD'];

        foreach (self::$routes as $path => $methodControllers) // as $route
            {

            if ($path != $targetPath)
            {
                continue;
            }

            foreach ($methodControllers as $method => $controller) // as $methodController
                {

                if ($method == $targetMethod)
                {

                    echo (new $controller())->$method();
                    return;
                }
            }
        }

        echo "404 Error: Page not found :(, please try to input another path";
    }

}
