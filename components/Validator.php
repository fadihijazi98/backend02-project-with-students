<?php

namespace component;

use constants\Rules;
use Controller\UserController;
use Mixins\BasicRulesValidation;
use mysql_xdevapi\Exception;

class Validator
{

    use BasicRulesValidation;
    public function __construct()
    {
      $this->validateImplementedRulesByConstants();
    }


    /**
     *
     * @throws \Exception
     * */
    private  function validateImplementedRulesByConstants(){
        $rules=(new Rules())->listOfExistConstant();
        foreach ($rules as $rule){
            $this->validateRuleIsImplemented($rule
                ,"Please sync your Rules constants with existing implementations in Validator component.");
        }
    }

    /**
     *
     * @throws \Exception
     * */
    private  function validateRuleIsImplemented($rule, $messageException){
        if (!method_exists($this,"validate_rule_is_".$rule)){
            throw new \Exception(  $messageException);
        }
    }

    /**
     *
     * represent shared validation data method
     *
     * @throws \Exception
     * */

    public static function validate($schema, $values, $level)
    {
        if ($schema!=null) {
            foreach ($schema as $key => $rules) {

                $value = null;

                if (key_exists($key, $values)) {
                    $value = $values[$key];
                }

                foreach ($rules as $rule) {
                    $rule_method = "validate_rule_is_" . $rule;
                    Validator::$rule_method($key, $value, $level);
                }
            }
        }
    }

    /**
     * represent validation Url Variables level
     *
     * @param  array $schema (associative array)
     * @param  array  $values (associative array)
     * @param  string  $level
     *
     * @return void
     *
     * @throws \Exception
     *
     * */

    public static function validateUrlVariables($schema, $values, $level)
    {
        self::validate($schema, $values, $level);

    }

    /**
     * represent validation query  params level
     *
     * @param  array $schema (associative array)
     * @param  array  $values (associative array)
     * @param  string  $level
     *
     * @return void
     *
     * @throws \Exception
     * */

    public static function validateQueryParams($schema, $values, $level)

    {
        self::validate($schema, $values, $level);

    }

    /**
     * represent validation payload data level
     *
     * @param  array $schema (associative array)
     * @param  array  $values (associative array)
     * @param  string  $level
     *
     * @return void
     *
     * @throws \Exception
     *
     * */
    public static function validatePayloadData($schema, $values, $level)
    {
        self::validate($schema, $values, $level);

    }



}
