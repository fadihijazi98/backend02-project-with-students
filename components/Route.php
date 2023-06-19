<?php

namespace Components;

require "helpers/RequestHelper.php";

use Helpers\RequestHelper;

class Route
{
    private static array $routes = [];
    private static int $version;

    /**
     * @throws \Exception
     */
    public static function setVersion($versionNumber): void
    {
        if($versionNumber == null || ! is_integer($versionNumber))
        {
            throw new \Exception("[Bad usage] version number can't be null nor any value except integer");
        }
        self::$version = $versionNumber;
    }

    public static function register($path,$method,$controller,$customHandler): void
    {
        $path = "api/v".self::$version."/".$path;
        self::$routes[$path][$method]["controller"] = $controller;
        self::$routes[$path][$method]["customHandler"] = $customHandler;

    }
    public static function GET($path, $controller,$customHandler = null): void
    {

        self::register($path,"GET",$controller,$customHandler);

    }
    public static function POST($path, $controller,$customHandler = null): void
    {

        self::register($path,"POST",$controller,$customHandler);

    }
    public static function PUT($path,$controller,$customHandler = null): void
    {
        self::register($path,"PUT",$controller,$customHandler);

    }
    public static function DELETE($path,$controller,$customHandler = null): void
    {
        self::register($path,"DELETE",$controller,$customHandler);

    }
    public static function mapPathWithParams($requestPathParts): array
    {
        foreach (self::$routes as $path => $methodControllers) // as $route
        {
            $explodedRegisteredPath = explode("/", $path);

            if (sizeof($explodedRegisteredPath) != sizeof($requestPathParts))
            {
                continue;
            }

            $isMatch = true;
            $parameters = [];

            foreach ($explodedRegisteredPath as $index => $item)
            {
                if (str_starts_with($item, "{") && str_ends_with($item, "}"))
                {
                    $parameters[] = $requestPathParts[$index];
                    continue;
                }

                if ($requestPathParts[$index] != $item)
                {
                    $isMatch = false;
                    break;
                }
            }

            if ($isMatch) {

                return
                    [
                    "path"=>$path,
                    "params"=>$parameters
                    ];
            }
        }
        return
            [
            "path"=>"",
            "params"=>""
            ];
    }
    public static function handleRequest(): array
    {
       $requestPathParts = RequestHelper::getRequestPathAsArray(true);

       $requestMethod = $_SERVER['REQUEST_METHOD'];

       $mappedPathParams = self::mapPathWithParams($requestPathParts);

       $requestPath = $mappedPathParams["path"];

       $requestParams = $mappedPathParams["params"];

       if(! $requestPath) //Means that if this request path is not defined
       {
           return ["message" => "Error 404: This request is not found unfortunately :("] ;
       }
       elseif (! key_exists($requestMethod,self::$routes[$requestPath]))
       {
           return ["message" => "There is no request registered with $requestMethod method"];
       }
       else
       {
           $controller = self::$routes[$requestPath][$requestMethod]["controller"];

           $customHandler = self::$routes[$requestPath][$requestMethod]["customHandler"];

           if($customHandler != null)
           {
               $requestMethod = $customHandler;
           }

           return (new $controller())->$requestMethod(... $requestParams);
       }

    }
}
