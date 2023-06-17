<?php

namespace Components;

/**
 * Validation is for many types,
 * Rule is a specific validation logic for something (like email, address, string, integer, ..etc.).
 * Rule implementation should be in methods start with validate_rule_is_*.
 */
class Validator
{

    /**
     * Represents validation of url variables level.
     * @param array $schema (associative array)
     * @param array $values (associative array)
     * @return void
     */
    public function validateUrlVariables($schema, $values) {
    }

    /**
     * Represents validation of query params level.
     * @param array $schema (associative array)
     * @param array $values (associative array)
     * @return void
     */
    public function validateQueryParams($schema, $values) {
    }

    /**
     * Represents request payload level.
     * @param array $schema (associative array)
     * @param array $values (associative array)
     * @return void
     */
    public function validateRequestPayload($schema, $values) {

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

    /**
     * The implementation of `required` rule.
     */
    private function validate_rule_is_required($key, $value) {

        if ($value == null) {

            throw new \Exception("The `$key` is required.");
        }
    }

    /**
     * The implementation of `string` rule.
     */
    private function validate_rule_is_string($key, $value) {

        if ($value != null && gettype($value) != 'string') {

            throw new \Exception("The $value should be string.");
        }
    }

    /**
     * The implementation of `integer` rule.
     */
    private function validate_rule_is_integer($key, $value) {

        if ($value != null && !is_integer($value)) {

            throw new \Exception("The $value should be integer");
        }
    }

    /**
     * The implementation of `boolean` rule.
     */
    private function validate_rule_is_boolean($value) {

        if ($value != null && !is_bool($value)) {

            throw new \Exception("The $value should be boolean");
        }
    }
}