<?php

namespace Components;

use Constants\Rules;

/**
 * Validation is for many types,
 * Rule is a specific validation logic for something (like email, address, string, integer, ..etc.).
 * Rule implementation should be in methods start with validate_rule_is_*.
 */
class Validator
{
    public function __construct()
    {
        $rules = (new Rules())->listOfExistsConstants();
        foreach ($rules as $rule) {

            $rule_method = "validate_rule_is_" . $rule;
            if (! method_exists($this, $rule_method)) {

                throw new \Exception("Please sync your Rules constants with existing implementations in Validator component.");
            }
        }
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
     * Represents validation of url variables level.
     * @param array $schema (associative array)
     * @param array $values (associative array)
     * @return void
     */
    public function validateUrlVariables($schema, $values) {

        $this->validate($schema, $values, "url variables level");
    }

    /**
     * Represents validation of query params level.
     * @param array $schema (associative array)
     * @param array $values (associative array)
     * @return void
     */
    public function validateQueryParams($schema, $values) {

        $this->validate($schema, $values, "query params level");
    }

    /**
     * Represents request payload level.
     * @param array $schema (associative array)
     * @param array $values (associative array)
     * @return void
     */
    public function validateRequestPayload($schema, $values) {

        $this->validate($schema, $values, "request payload level");
    }

    /**
     * The implementation of `required` rule.
     */
    private function validate_rule_is_required($key, $value, $level) {

        if ($value == null) {

            throw new \Exception("`$key` (in $level) is required.");
        }
    }

    /**
     * The implementation of `string` rule.
     */
    private function validate_rule_is_string($key, $value, $level) {

        if ($value != null && gettype($value) != 'string') {

            throw new \Exception("$key (in $level) within value = $value should be string.");
        }
    }

    /**
     * The implementation of `integer` rule.
     */
    private function validate_rule_is_integer($key, $value, $level) {

        if ($value != null && !ctype_digit("$value")) {

            throw new \Exception("$key (in $level) within value = $value should be integer.");
        }
    }

    /**
     * The implementation of `boolean` rule.
     */
    private function validate_rule_is_boolean($key, $value, $level) {

        $booleanValues = ["true", "false", true, false];
        if ($value != null && ! in_array($value, $booleanValues, true)) {

            throw new \Exception("$key (in $level) within value = $value should be boolean.");
        }
    }
}