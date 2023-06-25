<?php

namespace Mixin;

trait BasicRulesValidation
{
    /**
     * @throws \Exception
     */
    private function validate_rule_is_required($key, $value, $level)
    {
        if ($value == null) {
            throw new \Exception("the $key in $level is required! ");
        }
    }

    /**
     * @throws \Exception
     */
    private function validate_rule_is_string($key, $value, $level)
    {
        if ($value != null && gettype($value) != "string") {
            throw new \Exception("$key in $level within value : $value should be string.");
        }
    }

    /**
     * @throws \Exception
     */
    private function validate_rule_is_integer($key, $value, $level)
    {
        if ($value != null && !ctype_digit("$value")) {
            throw new \Exception("$key in $level within value : $value should be integer.");

        }
    }

    /**
     * @throws \Exception
     */
    private function validate_rule_is_boolean($key, $value, $level)
    {
        $booleanValues = ['true', 'false', true, false];

        if ($value != null && !in_array($value, $booleanValues, true)) {
            throw new \Exception("$key in $level within value : $value should be boolean.");

        }
    }

}