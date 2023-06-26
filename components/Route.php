<?php

namespace Components;

use Helpers\RequestHelper;


class Route
{
    private static array $routes = [];
    // It will be the container for all routes that user will ask to get in
    private static int $version;

    /**
     * @throws \Exception
     */
    /** Documentation:
     * 1.This method is required to add `api/versionNumber` to all registered requests.
     * 2.Assure to pass an integer and none null value when you are using this method.
     * @param integer $versionNumber
     * @return int
     * @throws \Exception when $versionNumber is null or not integer
     */
    public static function setVersion($versionNumber): void
    {
        if($versionNumber == null || ! is_integer($versionNumber))
        {
            throw new \Exception("[Bad usage] version number can't be null nor any value except integer");
        }
        self::$version = $versionNumber;
    }
    /* Documentation:
         * This function is required because in future the structure of
         * routes array may be changed, so it will reduce positions of change
         * and it will be the reference for all routes
         */
    public static function register($path,$method,$controller,$customHandler): void
    {
        $path = "api/v".self::$version."/".$path;
        self::$routes[$path][$method]["controller"] = $controller;
        self::$routes[$path][$method]["customHandler"] = $customHandler;

    }
    /* Documentation:
         * 1.This function will register the requests that are manipulated
         * by GET method with the specified controller to handle it
         * 2.When we don't get a value of custom handler because we didn't register it
         * when we call the requests method in index.php, the default value (null)
         * will be its value,and this point is true for all other request methods
         * (POST,PUT,DELETE)
         */
    public static function GET($path, $controller,$customHandler = null): void
    {

        self::register($path,"GET",$controller,$customHandler);

    }
    /* Documentation:
         * This function will register the requests that are manipulated
         * by POST method with the specified controller to handle it
         */
    public static function POST($path, $controller,$customHandler = null): void
    {

        self::register($path,"POST",$controller,$customHandler);

    }
    /* Documentation:
         * This function will register the requests that are manipulated
         * by PUT method with the specified controller to handle it
         */
    public static function PUT($path,$controller,$customHandler = null): void
    {
        self::register($path,"PUT",$controller,$customHandler);

    }
    /* Documentation:
        * This function will register the requests that are manipulated
        * by DELETE method with the specified controller to handle it
        */
    public static function DELETE($path,$controller,$customHandler = null): void
    {
        self::register($path,"DELETE",$controller,$customHandler);

    }
    /* Documentation:
       * 1.This function will receive the full URL, so we wrote the cutting
       * algorithm to only get the signature of the API or request
       *
       * 2.This function will map between the request (path) and the required
       * controller to manage it so that client get the wanted results of the
       * wanted API,and also map path with its parameters
       */
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
                    $paramKey = substr($item,1,strlen($item)-2);
                    $parameters[$paramKey] = $requestPathParts[$index];
                    continue;
                    /*
                      * 1. The continue statement represents the skip step for {id} item
                      * 2. The order of if statements is very important for the
                      * skip step
                      */
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
        $uri = RequestHelper::getUriWithOutQueryParams($_SERVER["REQUEST_URI"]);
       $requestPathParts = RequestHelper::getRequestPathAsArray($uri,true);

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
           /**
            * We have to send $routes[$requestPath] because this path
            * may be associated with different request methods, so we have to
            * check the correct request method with the specified path
            */
       }
       else
       {
           $controller = self::$routes[$requestPath][$requestMethod]["controller"];

           $customHandler = self::$routes[$requestPath][$requestMethod]["customHandler"];

           if($customHandler != null)
           {
               $requestMethod = $customHandler;
           }

           return (new $controller())->$requestMethod($requestParams);
       }

    }
}
