<?php

namespace Mixins;

use Exception;
use CustomExceptions\BadRequestException;

trait BasicRulesValidation
{
    /**
     * Implementation of string rule method
     * @throws BadRequestException when the $value is not null and not string
     */
    private function validateRuleIsString($key,$value,$level): void
    {
        if($value!=null && gettype($value) != "string")
        {
            throw new BadRequestException("'$key' within value = $value in $level level should be string dear user!!");
        }
    }

    /**
     * Implementation of integer rule method
     * @throws BadRequestException when the $value is null and not integer
     */
    private function validateRuleIsInteger($key,$value,$level): void
    {
        if($value!=null && !ctype_digit("$value"))
        {
            throw new BadRequestException("'$key' within value = $value in $level level should be integer dear user!!");
        }
    }

    /**
     * Implementation of boolean rule method
     * @throws BadRequestException when the $value is not null and not boolean
     */
    private function validateRuleIsBoolean($key,$value,$level): void
    {
        $booleanPossibleValues = ["true","false",true,false];
        if($value!=null && !in_array($value,$booleanPossibleValues,true));
        {
            throw new BadRequestException("'$key' within value = $value in $level level should be boolean dear user!!");
        }
    }

    /**
     * Implementation of required rule method
     * @throws BadRequestException when the $value of $key is null
     */
    private function validateRuleIsRequired($key,$value,$level): void
    {
        if($value==null)
        {
            throw new BadRequestException("'$key' in $level level is required dear user!!");
        }
    }
}