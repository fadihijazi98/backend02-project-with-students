<?php
namespace Component;


class Route{

    private static $requists=[];

    public static function GET($path, $controller){
        self::$requists[$path]=["GET"=>$controller];
    }

    public static function POST($path, $controller){
        self::$requists[$path]=["POST"=>$controller];
    }
    public static function viewRequists(){
        return self::$requists;
    }
    public static function requistsControllersMapper(){
        $uri=$_SERVER['REQUEST_URI'];
        $uriParts=explode("/",$uri);
        unset($uriParts[0]);
        unset($uriParts[1]);
        $requestedPath=join("/",$uriParts);
        $requestedMethod=$_SERVER['REQUEST_METHOD'];

        foreach(self::$requists as $path =>$methodController){
            if($path != $requestedPath){
                continue;
            }
            foreach($methodController as $method => $controller){
                if($method == $requestedMethod){
                    echo ((new $controller())->index());
                    return;
                }
            }
        }
        echo "Not Found !!!";

    }
}