<?php

namespace Helpers;

class RequestHelper
{
    public static function getRequestUriAsArray($excludeDomain = false) {

        $exploded_request_path = explode("/", $_SERVER['REQUEST_URI']);

        array_shift($exploded_request_path);
        if ($excludeDomain) {

            array_shift($exploded_request_path);
        }

        return $exploded_request_path;
    }
}