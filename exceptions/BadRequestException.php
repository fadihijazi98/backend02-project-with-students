<?php

namespace CustomExceptions;

use Constants\StatusCodes;
use Exception;

class BadRequestException extends Exception
{

    public function __construct($message)
    {

        parent::__construct($message, StatusCodes::VALIDATION_ERROR, null);
    }
}