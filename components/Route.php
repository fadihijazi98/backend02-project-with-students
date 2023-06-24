<?php
namespace Components;

use Helpers\RequestHelper;

class Route{

    private static $requists=[];
    private static int $version;

    public static function setVersion($versionNumber)
    {
        if($versionNumber == null || ! is_integer($versionNumber))
        {
            throw new \Exception("[Bad usage] version number can't be null nor any value except integer");
        }
        self::$version = $versionNumber;
    }

    

    private static function register($path,$method,$controller, $custom_handler){
        $path = "api/v".self::$version."/".$path;
        self::$requists[$path][$method]['controller']= $controller;
        self::$requists[$path][$method]['custom_handler']= $custom_handler;
    }

    public static function GET($path, $controller, $custom_handler=null){
        // self::$requists[$path]=["GET"=>$controller];
        self::register($path,"GET",$controller,$custom_handler);
    }

    public static function POST($path, $controller,$custom_handler=null){
        self::register($path,"POST",$controller,$custom_handler);
    }

    public static function PUT($path, $controller,$custom_handler=null){
        self::register($path,"PUT",$controller,$custom_handler);
    }
    public static function DELETE($path,$controller,$custom_handler=null){
        self::register($path,"DELETE",$controller,$custom_handler);
    }
    public static function viewRequists(){
        return self::$requists;
    }

    public static function handleRequest(){
        $uri = RequestHelper::getUriWithoutQueryParams($_SERVER['REQUEST_URI']);
        $path_parts = RequestHelper::getRequestUriAsArray($uri, true);
        $mapped_path_params = self::requistsControllersMapper($path_parts);

        $request_path = $mapped_path_params['path'];
        $request_params = $mapped_path_params['params'];
        $request_method = $_SERVER['REQUEST_METHOD'];
        
        if(! $request_path){
            return ["message"=>"request not found !"];

        } elseif(! key_exists($request_method,self::$requists[$request_path])){
            return["message"=> "request does not regestered with ". $request_method ." method"];
        }
        else{
            $controller = self::$requists[$request_path][$request_method]["controller"];
            $custom_handler = self::$requists[$request_path][$request_method]["custom_handler"];

            if ($custom_handler != null) {

                $request_method = $custom_handler;
            }
            
            return (new $controller())->$request_method($request_params);
        }

        // foreach(self::$requists[$request_path] as $method => $controller){
        //         if($method == $request_method){
        //             echo ((new $controller())->$method(... $request_params));
        //             return;
        //         }
        //     }
        // echo "request doesn't support ".$request_method ."as request method";

    }

    private static function requistsControllersMapper($request_path_parts){
        // $uriParts=explode("/",$requestURL);
        // unset($uriParts[0]);
        // unset($uriParts[1]);
        // $requestedPath=join("/",$uriParts);

        foreach(self::$requists as $path =>$methodController){

            $explodedRegestedPath=explode('/',$path);            
            if(sizeof($explodedRegestedPath)!=sizeof($request_path_parts)){
                continue;
            }
            $params=[];
            $isMatch=true;
            foreach($explodedRegestedPath as $index => $item){
                if(str_starts_with($item,'{')&& str_ends_with($item,'}')){
                    $param_key = substr($item, 1, strlen($item) - 2);
                    $params[$param_key] = $request_path_parts[$index];
                    continue;
                }
                if($item != $request_path_parts[$index]){
                    $isMatch=false;
                    break;
                }
            }
            if($isMatch){
                return[
                    'path' => $path,
                    'params' => $params
                ];
            }
            return [
                'path' => '',
                'params' => ''
            ];
            
        }

    }
}