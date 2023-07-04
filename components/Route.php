<?php

namespace component;

use http\Url;

class Route
{
    private static $routes=[];

    private static function register($path,$method,$controller){
        self::$routes[$path][$method]=$controller;
    }

    public  static function GET($path,$controller){
        self::$routes[$path]["GET"]=$controller;
        self::register($path,"GET",$controller);
    }
    public static function POST($path,$controller){
        self::register($path,"POST",$controller);

    }
    public static function PUT($path,$controller){
        self::register($path,"PUT",$controller);
    }
    public static function DELETE($path,$controller){
        self::register($path,"DELETE",$controller);
    }

    public static function printRoutes(){
        var_dump(self::$routes);

    }



    public static function mapRequestWithMethod($requestUrl )
    {

        $parts = explode('/', $requestUrl);
        unset($parts[0]);
        unset($parts[1]);
        $requestPath = join('/', $parts);

        $isMatch = true;
        $params = [];
        $tempPath="";

        foreach (self::$routes as $path => $methodController) {
            $explodeRequestPath = explode("/", $requestPath);
            $explodeTargetPath = explode("/", $path);


            if (sizeof($explodeRequestPath) != sizeof($explodeTargetPath)) {
                continue;
            }


            foreach ($explodeTargetPath as $index => $item) {

                if (str_starts_with($item, "{") && str_ends_with($item, "}")) {
                    $params[] = $explodeRequestPath[$index];
                    continue;
                }

                if ($item != $explodeRequestPath[$index]) {
                    $isMatch = false;
                    break;
                }
            }

            if ($isMatch) {
                return
                    [
                       "path"=> $path,
                        "params"=>$params
                    ];

            }

        }
        return [
            "path"=>"",
            "params"=>""
        ];


    }



    public static function handelRequest(){

        $requestUrl=$_SERVER['REQUEST_URI'];
        $requestMethod = $_SERVER['REQUEST_METHOD'];
        $mappedPathParams=self::mapRequestWithMethod($requestUrl);


        if (empty($mappedPathParams))
        {
            echo "Request not found";
            return;
        }

        $path=$mappedPathParams['path'];
        $params=$mappedPathParams['params'];


        foreach (  self::$routes[$path] as $method => $controller){

                if( $requestMethod == $method)
                {

                   echo (new $controller())->$method(...$params);

                    return;

                }

        }
        echo "request doesn't support  ".$requestMethod." as request method ";



    }




}