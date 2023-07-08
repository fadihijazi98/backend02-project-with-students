<?php
namespace Helpers;

class RequestHelper
{

    public static function getRequestUri() {

        return $_SERVER['REQUEST_URI'];
    }

    /**
     * @return string
     */
    public static function getUriWithoutQueryParams() {

        $exploded_request_path_and_query_params = explode("?", self::getRequestUri());
        return array_shift($exploded_request_path_and_query_params);
    }

    /**
     * Split the uri path into parts (array),
     * Note: if you need uri path without domain, set the `$excludeDomain` arg as true.
     *
     * E.g:
     * uri = "facebook.com/users"
     * returned value is ["facebook.com", "users"]
     *
     * @param string $uri excepted uri to be without query params.
     * @param boolean $excludeDomain
     * @return string[]
     */
    public static function getRequestUriAsArray($uri, $excludeDomain = false) {

        $exploded_request_path = explode("/", $uri);

        array_shift($exploded_request_path);
        if ($excludeDomain) {

            array_shift($exploded_request_path);
        }

        return $exploded_request_path;
    }

    /**
     * Get data that sent as raw string in json format,
     * To get as associative array data-structure represents the request payload data.
     *
     * @return array
     */
    public static function getRequestPayload() {

        $data_as_string_in_json_format = file_get_contents("php://input");

        if (! $data_as_string_in_json_format) {

            return [];
        }
        return json_decode($data_as_string_in_json_format, true);
    }

    public static function extractResourceIdFromRequestPath() {

        $path_parts = self::getRequestUriAsArray(self::getRequestUri());

        $resource = array_pop($path_parts);
        if (ctype_digit($resource)) {

            return $resource;
        }

        return null;
    }
}