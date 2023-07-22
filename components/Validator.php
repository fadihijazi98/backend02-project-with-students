<?php

namespace Components;
use Constants\Rules;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Mixins\BasicRulesValidation;
use Mixins\DatabaseRulesValidation;
use Models\User;

class Validator
{
    use BasicRulesValidation, DatabaseRulesValidation;

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

        foreach ($rules as $rule) {
            $ruleMethod = "validateRuleIs" . $rule;

            if (!method_exists($this, $ruleMethod)) {
                $this->validateRuleIsImplemented($rule, "Desired method rule isn't implemented :(, try another one by examining exist rules constants!!");
            }
        }
    }

    /**
     * @throws Exception
     */
    private function validateRuleIsImplemented($rule, $exceptionMessage): void
    {
        $rule_method = "validateRuleIs" . $rule;

        if (!method_exists($this, $rule_method)) {

            throw new Exception($exceptionMessage);
        }
    }

    /**
     * @throws Exception
     */
    private function validate($schema, $values, $level)
    {
        $value = null;

        foreach ($schema as $key => $rules)
        {
            if (key_exists($key, $values))
            {
                $value = $values[$key];
            }

            foreach ($rules as $specialRule => $rule)
            {

                $arguments = [$key, $value, $level];

                if (!is_array($rule) && $rule === Rules::UNIQUE)
                {
                    throw new Exception("UNIQUE rule should have another level of data having 'model' value");

                }
                else if (is_array($rule))
                {

                    if (key_exists("model", $rule))
                    {

                        $arguments[] = $rule["model"];
                    }

                    $rule = $specialRule;
                }

            $ruleMethod = "validateRuleIs" . $rule;

            if (!method_exists($this, $ruleMethod))
            {
                $this->validateRuleIsImplemented($rule, "'$rule' method isn't implemented unfortunately :(, examine exist rules constants to reach exist rule methods");
            }

            $this->$ruleMethod(... $arguments);
        }
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