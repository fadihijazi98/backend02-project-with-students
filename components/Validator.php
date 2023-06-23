<?php

namespace Components;
use Exception;

class Validator
{
    public function validateUrlVariables($schema, $values)
    {

    }
    public function validateQueryParameters($schema, $values)
    {

    }
    public function validateRequestPayload($schema, $values)
    {
        $value = null;
        foreach ($schema as $key=>$rules)
        {
            if(key_exists($key,$values))
            {
                $value = $values[$key];
            }
        }
        foreach ($rules as $rule)
        {
            $ruleMethod = "validateRuleIs".$rule;
            $this->$ruleMethod($key,$value);
        }

    }

    /**
     * Implementation of string rule method
     * @throws Exception when the $value is not null and not string
     */
    private function validateRuleIsString($key,$value): void
    {
        if($value!=null && !gettype($value))
        {
            throw new Exception("The datatype of $value should be string dear user!!");
        }
    }

    /**
     * Implementation of integer rule method
     * @throws Exception when the $value is null and not integer
     */
    private function validateRuleIsInteger($key,$value): void
    {
        if($value!=null && !is_integer($value))
        {
            throw new Exception("The datatype of $value should be integer dear user!!");
        }
    }

    /**
     * Implementation of boolean rule method
     * @throws Exception when the $value is not null and not boolean
     */
    private function validateRuleIsBoolean($key,$value): void
    {
        if($value!=null && !is_bool($value))
        {
            throw new Exception("The datatype of $value should be boolean dear user!!");
        }
    }

    /**
     * Implementation of required rule method
     * @throws Exception when the $value of $key is null
     */
    private function validateRuleIsRequired($key,$value): void
    {
        if($value==null)
        {
            throw new Exception("The '$key' is required dear user!!");
        }
    }
}