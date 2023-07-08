<?php

namespace Components;

use Constants\Rules;
use Illuminate\Database\Eloquent\Model;
use Mixins\BasicRulesValidation;
use Mixins\DatabaseRulesValidation;
use Models\User;

/**
 * Validation is for many types,
 * Rule is a specific validation logic for something (like email, address, string, integer, ..etc.).
 * Rule implementation should be in methods start with validate_rule_is_*.
 */
class Validator
{
    use BasicRulesValidation, DatabaseRulesValidation;

    /**
     * @throws \Exception
     */
    public function __construct()
    {
        $this->validateImplementedRulesConstants(); //
    }

    /**
     * @throws \Exception
     */
    private function validateRuleIsImplemented($rule, $exceptionMessage) {

        $rule_method = "validate_rule_is_" . $rule;
        if (! method_exists($this, $rule_method)) {

            throw new \Exception($exceptionMessage);
        }

    }

    /**
     * @throws \Exception
     */
    private function validateImplementedRulesConstants() {

        $rules = (new Rules())->listOfExistsConstants();
        foreach ($rules as $rule) {

            $this->validateRuleIsImplemented(
                $rule,
                "Please sync your Rules constants with existing implementations in Validator component.");
        }
    }

    private function validate($schema, $values, $level) {

        foreach ($schema as $key => $rules) {

            $value = null;
            if (key_exists($key, $values)) {

                $value = $values[$key];
            }

            foreach ($rules as $specialRule => $rule) {

                $arguments = [$key, $value, $level];

                if (! is_array($rule) && $rule === Rules::UNIQUE) {

                    throw new \Exception("UNIQUE Rule should have another level of data having `model` value.");
                }
                else if (is_array($rule)) {


                    if (key_exists("model", $rule)) {

                        $arguments[] = $rule["model"];
                    }
                    $rule = $specialRule;
                }

                $this->validateRuleIsImplemented(
                    $rule,
                    "`$rule` isn't implemented, please use Rules constant class to skip this kind of errors.");

                $rule_method = "validate_rule_is_" . $rule;
                $this->$rule_method(... $arguments);
            }
        }
    }

    /**
     * Represents validation of url variables level.
     * @param array $schema (associative array)
     * @param array $values (associative array)
     * @param Model $model
     * @return void
     * @throws \Exception
     */
    public function validateUrlVariables($schema, $values) {

        $this->validate($schema, $values, "url variables level");
    }

    /**
     * Represents validation of query params level.
     * @param array $schema (associative array)
     * @param array $values (associative array)
     * @param Model $model
     * @return void
     * @throws \Exception
     */
    public function validateQueryParams($schema, $values) {

        $this->validate($schema, $values, "query params level");
    }

    /**
     * Represents request payload level.
     * @param array $schema (associative array)
     * @param array $values (associative array)
     * @param Model $model
     * @return void
     * @throws \Exception
     */
    public function validateRequestPayload($schema, $values) {

        $this->validate($schema, $values, "request payload level");
    }
}