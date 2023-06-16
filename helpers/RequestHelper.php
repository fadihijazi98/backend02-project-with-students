<?php

namespace Helpers;

class RequestHelper
{
    /** Documentation:
     * Explode the request URI into parts and store it in an array
     * Note that if you need request URI without domain,assign the value of
     * `$excludeDomain` parameter as true.
     * The array_shift() function removes the first element from an array,
     * and returns the value of the removed element
     * @param boolean $excludeDomain
     * @return string[]
     */
    public static function getRequestPathAsArray($excludeDomain = false): array
    {
        $explodedRequestPath = explode("/", $_SERVER["REQUEST_URI"]);

        array_shift($explodedRequestPath);

        if($excludeDomain)
        {
            array_shift($explodedRequestPath);
        }

        return $explodedRequestPath;
    }

}