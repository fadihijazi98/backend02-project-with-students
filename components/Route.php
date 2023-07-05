<?php

namespace component;
use helpers\RequestHelper;

require "vendor/autoload.php";

/*
 *
 * Request is a path and method.
 * Route is a map between Request & Controller.
 * $routes structure:
 *
 * [
 *      "path" => [
 *          "method" => [
 *                         "controller" => controller,
 *                         "custom_handler" => handler
 *                      ]
 *                ], ....
 * ]
 *
 */
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

/*
 * the returned value structured like
 *
 *    [ "path" => String ,
 *      "params" => string[]
 *    ]
 *
 * @param string[] $request_path_parts
 * @return string[]
 *
 * */

    public static function mapRequestWithMethod($request_path_parts )
    {

        $isMatch=true;
        $params=[];
        foreach (self::$routes as $path => $methodController) {
            $explode_registered_Path = explode("/", $path);

            if (sizeof($explode_registered_Path) != sizeof($request_path_parts)) {

            continue;
            }


            foreach ($explode_registered_Path as $index => $item) {

                if (str_starts_with($item, "{") && str_ends_with($item, "}")) {
                    $params[] = $request_path_parts[$index];
                    continue;
                }

                if ($item != $request_path_parts[$index]) {
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

        $path_parts=RequestHelper::getRequestUriAsArray(true);

        $mappedPathParams=self::mapRequestWithMethod($path_parts);

        $request_path=$mappedPathParams['path'];
        $request_params=$mappedPathParams['params'];
        $request_method = $_SERVER['REQUEST_METHOD'];


        if (empty($mappedPathParams))
        {
            echo "Request not found";
            return;
        }

        if (!key_exists($request_method,self::$routes[$request_path])){
            echo "request isn't registered with  ".$request_method." method  ";
        }

        else {


            $controller=self::$routes[$request_path][$request_method];

                    /* @var array $request_params */

                    echo (new $controller())->$request_method(...$request_params);

        }


    }
}