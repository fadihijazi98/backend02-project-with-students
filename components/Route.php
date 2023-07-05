<?php

namespace component;
use helpers\RequestHelper;
use mysql_xdevapi\Exception;

require "vendor/autoload.php";

/**
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
    private static $version=1;

    public static function setVersion($version_number){
        if ($version_number==null || !is_integer($version_number)){
            throw new Exception("[Bad Use] Version number cant be null or none integer .");
        }
        self::$version=$version_number;
    }

    private static function register($path,$method,$controller,$custom_handler=null){
        $path="api/v".self::$version."/".$path;
        self::$routes[$path][$method]["controller"]=$controller;
        self::$routes[$path][$method]["custom_handler"]=$custom_handler;

    }

    public  static function GET($path,$controller,$custom_handler=null){
        self::register($path,"GET",$controller,$custom_handler);
    }
    public static function POST($path,$controller,$custom_handler=null){
        self::register($path,"POST",$controller,$custom_handler);

    }
    public static function PUT($path,$controller,$custom_handler=null){
        self::register($path,"PUT",$controller,$custom_handler);
    }
    public static function DELETE($path,$controller,$custom_handler=null){
        self::register($path,"DELETE",$controller,$custom_handler);
    }

    public static function printRoutes(){
        var_dump(self::$routes);

    }

/**
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

        $params=[];
        foreach (self::$routes as $path => $methodController) {
            $isMatch=true;

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
            $custom_handler=self::$routes[$request_path][$request_method]["custom_handler"];
            $controller=self::$routes[$request_path][$request_method]["controller"];

            if ($custom_handler!=null) {
                $request_method = $custom_handler;
            }

                    /* @var array $request_params */


                    echo (new $controller())->$request_method(...$request_params);

        }


    }
}