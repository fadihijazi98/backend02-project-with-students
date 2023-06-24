<?php

namespace Components;
use Constants\Rules;
use Exception;

class Validator
{
    /**
     * @throws Exception
     */
    public function __construct()
    {
        $rules = (new Rules())->listOfExistConstants();
        foreach ($rules as $rule)
        {
            $ruleMethod = "validateRuleIs".$rule;
            if(!method_exists($this,$ruleMethod))
            {
                throw new Exception("Desired method rule isn't implemented :(, try another one by examining exist rules constants!!");
            }
        }
    }

    /**
     * @throws Exception
     */
    private function validate($schema, $values, $level)
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
            if(!method_exists($this,$ruleMethod))
            {
                throw new Exception("'rule' method isn't implemented unfortunately :(, examine exist rules constants to reach exist rule methods");
            }
            $this->$ruleMethod($key,$value,$level);
        }
    }
    public function validateUrlVariables($schema,$values)
    {
         $this->validate($schema,$values,"URL variables");
    }
    public function validateQueryParameters($schema,$values)
    {
         $this->validate($schema,$values,"Query parameters");
    }
    public function validateRequestPayload($schema,$values,$level)
    {
        $this->validate($schema,$values,"Request payload");
    }

    /**
     * Implementation of string rule method
     * @throws Exception when the $value is not null and not string
     */
    private function validateRuleIsString($key,$value,$level): void
    {
        if($value!=null && gettype($value) != "string")
        {
            throw new Exception("'$key' within value = $value in $level level should be string dear user!!");
        }
    }

    /**
     * Implementation of integer rule method
     * @throws Exception when the $value is null and not integer
     */
    private function validateRuleIsInteger($key,$value,$level): void
    {
        if($value!=null && !ctype_digit("$value"))
        {
            throw new Exception("'$key' within value = $value in $level level should be integer dear user!!");
        }
    }

    /**
     * Implementation of boolean rule method
     * @throws Exception when the $value is not null and not boolean
     */
    private function validateRuleIsBoolean($key,$value,$level): void
    {
        if($value!=null && !is_bool($value))
        {
            throw new Exception("'$key' within value = $value in $level level should be boolean dear user!!");
        }
    }

    /**
     * Implementation of required rule method
     * @throws Exception when the $value of $key is null
     */
    private function validateRuleIsRequired($key,$value,$level): void
    {
        if($value==null)
        {
            throw new Exception("'$key' in $level level is required dear user!!");
        }
    }
}