<?php

namespace CustomExceptions;

use Constants\ResponseStatusCodes;
use Exception;

class BadRequestException extends Exception
{
    public function __construct($message)
    {

        parent::__construct($message, ResponseStatusCodes::VALIDATION_ERROR, null);
    }

}