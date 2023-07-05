<?php

namespace CustomExceptions;
use Exception;
use Constants\StatusCodes;

class ResourceNotFound extends Exception
{
    public function __construct()
    {
        parent::__construct("Resource Not Found!",StatusCodes::NOT_FOUND,null);
    }

}