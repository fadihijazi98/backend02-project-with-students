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

    public static function getRequestPayload() {

        $data_as_string_in_json_format = file_get_contents("php://input");

        if (! $data_as_string_in_json_format) {

            return [];
        }
        return json_decode($data_as_string_in_json_format, true);
    }

}