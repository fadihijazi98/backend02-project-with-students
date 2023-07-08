<?php

namespace Mixins;

use CustomExceptions\BadRequestException;

trait BasicRulesValidation {

    /**
     * The implementation of `required` rule.
     * @throws BadRequestException
     */
    private function validate_rule_is_required($key, $value, $level) {

        if ($value == null) {

            throw new BadRequestException("`$key` (in $level) is required.");
        }
    }

    /**
     * The implementation of `string` rule.
     * @throws BadRequestException
     */
    private function validate_rule_is_string($key, $value, $level) {

        if ($value != null && gettype($value) != 'string') {

            throw new BadRequestException("$key (in $level) within value = $value should be string.");
        }
    }

    /**
     * The implementation of `integer` rule.
     * @throws BadRequestException
     */
    private function validate_rule_is_integer($key, $value, $level) {

        if ($value != null && !ctype_digit("$value")) {

            throw new BadRequestException("$key (in $level) within value = $value should be integer.");
        }
    }

    /**
     * The implementation of `boolean` rule.
     * @throws BadRequestException
     */
    private function validate_rule_is_boolean($key, $value, $level) {

        $booleanValues = ["true", "false", true, false];
        if ($value != null && ! in_array($value, $booleanValues, true)) {

            throw new BadRequestException("$key (in $level) within value = $value should be boolean.");
        }
    }
}