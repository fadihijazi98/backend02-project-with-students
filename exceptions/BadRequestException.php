<?php

namespace CustomExceptions;
use Exception;
use Constants\StatusCodes;

class BadRequestException extends Exception
{
    public function __construct($message)
    {
        parent::__construct($message,StatusCodes::VALIDATION_ERROR,null);
    }
}