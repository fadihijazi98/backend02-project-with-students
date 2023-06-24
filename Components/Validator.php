<?php

namespace Components;

use Constants\Rules;

class Validator
{
    /**
     * @throws \Exception
     */
    public function __construct()
    {
        $rules = (new Rules())->listOfExistsConstants();

        foreach ($rules as $rule){

            $rule_method= "validate_rule_is_" . $rule;

            if(!method_exists($this,$rule_method)){

                throw new \Exception("Please sync your Rules constants with existing implementations in Validator component.");

            }
        }
    }

    /**
     * @throws \Exception
     */
    private function validate($schema, $values, $level){

        foreach ($schema as $key => $rules) {

            $value =null;

            if (key_exists($key, $values)) {
                $value = $values[$key];
            }

            foreach ($rules as $rule) {

                $rule_method = "validate_rule_is_" . $rule;
                if (! method_exists($this, $rule_method)) {

                    throw new \Exception(" $rule isn't implemented , please use rules constant class to skip this kind of errors.");
                }
                $this->$rule_method($key, $value, $level);
            }
        }
    }

    public function validateUrlVariables($schema, $values)
    {
        $this->validate($schema, $values, "url variables level");

    }

    public function validateQueryParams($schema, $values)
    {
        $this->validate($schema, $values, "query params level");

    }


    public function validateRequestPayload($schema, $values)
    {
        $this->validate($schema, $values, "request payload level");

    }


    private function validate_rule_is_required($key, $value, $level)
    {
        if ($value == null) {
            throw new \Exception("the $key in $level is required! ");
        }
    }

        private function validate_rule_is_string($key, $value,$level)
        {
            if ($value != null && gettype($value) != "string") {
                throw new \Exception("$key in $level within value : $value should be string.");
            }
        }

        private function validate_rule_is_integer($key, $value,$level)
        {
            if ($value != null && !ctype_digit("$value")) {
                throw new \Exception("$key in $level within value : $value should be integer.");

            }
        }

        private function validate_rule_is_boolean($key, $value,$level)
        {
            $booleanValues = ['true','false',true,false];

            if ($value != null && !in_array($value,$booleanValues,true)) {
                throw new \Exception("$key in $level within value : $value should be boolean.");

            }
        }


    }