<?php
namespace Helpers;

class RequestHelper
{

    /**
     * Split the uri path into parts (array),
     * Note: if you need uri path without domain, set the `$excludeDomain` arg as true.
     *
     * E.g:
     * uri = "facebook.com/users"
     * returned value is ["facebook.com", "users"]
     *
     * @param boolean $excludeDomain
     * @return string[]
     */
    public static function getRequestUriAsArray($excludeDomain = false) {

        $exploded_request_path = explode("/", $_SERVER['REQUEST_URI']);

        array_shift($exploded_request_path);
        if ($excludeDomain) {

            array_shift($exploded_request_path);
        }

        return $exploded_request_path;
    }
}