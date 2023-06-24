<?php

namespace Components;

use Constants\Rules;

class Validator {

    public function __construct(){
    $rules = (new Rules())->listOfExistsConstants();
        foreach ($rules as $rule) {

            $rule_method = "validate_rule_is_" . $rule;
            if (! method_exists($this, $rule_method)) {

                throw new \Exception("Please sync your Rules constants with existing implementations in Validator component.");
            }
        }
    }

    public function validateUrlVariables($schema, $values) {
        $this->validate($schema, $values, "url variables level");
    }

    public function validateQueryParams($schema, $values) {
         $this->validate($schema, $values, "query params level");
    }

    public function validateRequestPayload($schema, $values) {
        
        var_dump($values);die();
        $this->validate($schema, $values, "request payload level");
        
    }
    private function is_boolean($val){
        $booleanValues = ["true", "false", true, false];
        if (in_array($val, $booleanValues, true)){
            return true;
        }
        return false;
    }
    private function validate($schema, $values, $level) {
        foreach ($schema as $key => $rules) {

            $value = null;
            if (key_exists($key, $values)) {
                
                $value = $values[$key];
            }

            foreach ($rules as $rule) {

                $rule_method = "validate_rule_is_" . $rule;
                if (! method_exists($this, $rule_method)) {

                    throw new \Exception("`$rule` isn't implemented, please use Rules constant class to skip this kind of errors.");
                }
                
                $this->$rule_method($key, $value, $level);
            }
        }
    }
   

    /**
     * The implementation of `required` rule.
     */
    private function validate_rule_is_required($key, $value,$level) {

        if ($value == null) {

            throw new \Exception("The `$key` is required.");
        }
    }

    /**
     * The implementation of `string` rule.
     */
    private function validate_rule_is_string($key,$value,$level) {
        
        if (($value != null && gettype($value) != 'string') || $this->is_boolean($value)) {

            throw new \Exception("$key (in $level): $value should be string.");
        }
    }

    /**
     * The implementation of `integer` rule.
     */
    private function validate_rule_is_integer($key, $value,$level) {

        if ($value != null && !ctype_digit("$value")) {

            throw new \Exception("$key (in $level): $value should be integer.");
        }
    }

    /**
     * The implementation of `boolean` rule.
     */
    private function validate_rule_is_boolean($key,$value,$level) {

        if ($value != null && ! $this->is_boolean($value)) {

            throw new \Exception("$key (in $level) within value = $value should be boolean.");
        }
    }
}