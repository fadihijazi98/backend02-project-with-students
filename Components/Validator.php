<?php

namespace Components;

use mysql_xdevapi\Exception;

class Validator
{
    public function ValidateUrlVariables($schema, $values)
    {

    }

    public function ValidateQueryParams($schema, $values)
    {

    }

    public function ValidateRequestPayload($schema, $values)
    {
        foreach ($schema as $key => $rules) {

            $value = null;
            if (key_exists($key, $values)) {

                $value = $values[$key];
            }

            foreach ($rules as $rule) {

                $rule_method = "validate_rule_is_" . $rule;
                $this->$rule_method($key, $value);
            }
        }
    }

    private function validate_rule_is_required($key, $value)
    {
        if ($value == null) {
            throw new Exception("the $key is required! ");
        }
    }

        private function validate_rule_is_string($key, $value)
        {
            if ($value != null && gettype($value) != "string") {
                throw new Exception("$value should be string.");
            }
        }

        private function validate_rule_is_integer($key, $value)
        {
            if ($value != null && !is_integer($value)) {
                throw new Exception("$value should be integer.");

            }
        }

        private function validate_rule_is_boolean($key, $value)
        {
            if ($value != null && !is_bool($value)) {
                throw new Exception("$value should be boolean.");

            }
        }


    }