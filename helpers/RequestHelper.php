<?php

namespace Helpers;

class RequestHelper
{

    public static function getRequestUri()
    {
        return $_SERVER['REQUEST_URI'];
    }


    /** Documentation:
     * Explode the request URI into parts and store it in an array
     * Note that if you need request URI without domain,assign the value of
     * `$excludeDomain` parameter as true.
     * The array_shift() function removes the first element from an array,
     * and returns the value of the removed element
     * @param boolean $excludeDomain
     * @return string[]
     */
    public static function getUriWithOutQueryParams()
    {
        $explodedRequestPathWithQueryParams = explode("?",self::getRequestUri());

        return array_shift($explodedRequestPathWithQueryParams);
    }

    public static function getRequestPathAsArray($uri,bool $excludeDomain = false): array
    {
        $explodedRequestPath = explode("/", $uri);

        array_shift($explodedRequestPath);

        if($excludeDomain)
        {
            array_shift($explodedRequestPath);
        }

        return $explodedRequestPath;
    }

    public static function getRequestPayload()
    {
        $dataAsStringInJsonFormat = file_get_contents("php://input");

        if(! $dataAsStringInJsonFormat)
        {
            return [];
        }
        return json_decode($dataAsStringInJsonFormat,true);
    }

    public static function extractResourceIdFromRequestPath()
    {

        $pathParts = self::getRequestUriAsArray(self::getRequestUri());

        $resourceId = array_pop($pathParts);

        if (ctype_digit($resourceId))
        {

            return $resourceId;
        }

        return null;
    }
}