<?php

namespace Components;
use Constants\Rules;
use Exception;
use Mixins\BasicRulesValidation;

class Validator
{
    use BasicRulesValidation;
    /**
     * @throws Exception
     */
    public function __construct()
    {
        $this->validateImplementedRulesConstants();
    }
    private function validateImplementedRulesConstants()
    {
        $rules = (new Rules())->listOfExistConstants();
        foreach ($rules as $rule)
        {
            $ruleMethod = "validateRuleIs".$rule;
            if(!method_exists($this,$ruleMethod))
            {
                $this->validateRuleIsImplemented($rule,"Desired method rule isn't implemented :(, try another one by examining exist rules constants!!");
            }
        }
    }
    /**
     * @throws Exception
     */
    private function validateRuleIsImplemented($rule, $exceptionMessage): void
    {
        $rule_method = "validateRuleIs".$rule;
        if (! method_exists($this, $rule_method))
        {

            throw new \Exception($exceptionMessage);
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
                $this->validateRuleIsImplemented($rule,"'$rule' method isn't implemented unfortunately :(, examine exist rules constants to reach exist rule methods");
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


}