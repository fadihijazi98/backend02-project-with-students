<?php

namespace Constants;

use ReflectionClass;

class BaseConstants
{

    public function listOfExistConstants()
    {
        return (new ReflectionClass($this))->getConstants();
    }

}