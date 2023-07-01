<?php

namespace CustomExceptions;

use Constants\StatusCodes;
use Exception;

class ResourceNotFound extends Exception
{

    public function __construct()
    {

        parent::__construct("Resource Not found.", StatusCodes::NOT_FOUND, null);
    }
}