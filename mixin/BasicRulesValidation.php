<?php

namespace Mixins;

trait BasicRulesValidation {

    /**
     * The implementation of `required` rule.
     * @throws \Exception
     */
    private function validate_rule_is_required($key, $value, $level) {

        if ($value == null) {

            throw new \Exception("`$key` (in $level) is required.");
        }
    }

    /**
     * The implementation of `string` rule.
     * @throws \Exception
     */
    private function validate_rule_is_string($key, $value, $level) {

        if ($value != null && gettype($value) != 'string') {

            throw new \Exception("$key (in $level) within value = $value should be string.");
        }
    }

    /**
     * The implementation of `integer` rule.
     * @throws \Exception
     */
    private function validate_rule_is_integer($key, $value, $level) {

        if ($value != null && !ctype_digit("$value")) {

            throw new \Exception("$key (in $level) within value = $value should be integer.");
        }
    }

    /**
     * The implementation of `boolean` rule.
     * @throws \Exception
     */
    private function validate_rule_is_boolean($key, $value, $level) {

        $booleanValues = ["true", "false", true, false];
        if ($value != null && ! in_array($value, $booleanValues, true)) {

            throw new \Exception("$key (in $level) within value = $value should be boolean.");
        }
    }
}