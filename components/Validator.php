<?php

namespace component;

use Controller\UserController;

class Validator
{


    public static function validate($schema, $values, $level)
    {
        foreach ($schema as $key => $rules) {


            $value = null;


            if (key_exists($key, $values)) {
                $value = $values[$key];
            }


            foreach ($rules as $rule) {
                $rule_method = "validate_rule_is_" . $rule;
                Validator::$rule_method($key, $value, $level);
            }
        }
    }

    /**
     * represent validation Url Variables level
     *
     * @param  array $schema (associative array)
     * @param  array  $values (associative array)
     * @param  string  $level
     *
     * @return void
     *
     * */

    public static function validateUrlVariables($schema, $values, $level)
    {
        self::validate($schema, $values, $level);
    }

    /**
     * represent validation query  params level
     *
     * @param  array $schema (associative array)
     * @param  array  $values (associative array)
     * @param  string  $level
     *
     * @return void
     *
     * */

    public static function validateQueryParams($schema, $values, $level)

    {
        self::validate($schema, $values, $level);

    }

    /**
     * represent validation payload data level
     *
     * @param  array $schema (associative array)
     * @param  array  $values (associative array)
     * @param  string  $level
     *
     * @return void
     *
     * */
    public static function validatePayloadData($schema, $values, $level)
    {
        self::validate($schema, $values, $level);
    }

   /**
    * the implementation of 'required' rule.
    * */
    public static function validate_rule_is_boolean($key, $value, $level)

    {
        $booleanValue = ["true", "false", true, false];

        if ($value!=null && !in_array($value, $booleanValue,true)) {

            throw new \Exception("The value #$value in $level must be boolean value false or true .", 300);
        }
    }

    public static function validate_rule_is_integer($key, $value, $level)
    {
        if ($value != null && !ctype_digit("$value")) {


            throw new \Exception("The value #$value in $level must be an integer.", 500);
        }
    }

    public static function validate_rule_is_string($key, $value, $level)
    {
        if ($value != null && !is_string($value))
            throw new \Exception("The value #$value in $level must be a string .", 300);

    }

    public static function validate_rule_is_required($key, $value, $level)
    {

        if (!$value)
            throw new \Exception("The value of \" $key \" cannot be null in $level.", 500);


    }


}
