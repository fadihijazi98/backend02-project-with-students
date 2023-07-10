<?php
namespace Mixins;

trait BasicRulesValidation{


    /**
     * the implementation of 'boolean' rule.
     *
     * @throws \Exception
     * */
    public static function validate_rule_is_boolean($key, $value, $level)

    {
        $booleanValue = ["true", "false", true, false];

        if ($value!=null && !in_array($value, $booleanValue,true)) {

            throw new \Exception("The value #$value in $level must be boolean value false or true .", 300);
        }
    }

    /**
     * the implementation of 'integer' rule.
     *
     * @throws \Exception
     * */

    public static function validate_rule_is_integer($key, $value, $level)
    {
        if ($value != null && !ctype_digit("$value")) {


            throw new \Exception("The value #$value in $level must be an integer.", 500);
        }
    }

    /**
     * the implementation of 'string' rule.
     *
     * @throws \Exception
     * */

    public static function validate_rule_is_string($key, $value, $level)
    {
        if ($value != null && !is_string($value))
            throw new \Exception("The value #$value in $level must be a string .", 300);

    }

    /**
     * the implementation of 'required' rule.
     *
     * @throws \Exception
     * */
    public static function validate_rule_is_required($key, $value, $level)
    {

        if (!$value)
            throw new \Exception("The value of \" $key \" cannot be null in $level.", 500);


    }

}