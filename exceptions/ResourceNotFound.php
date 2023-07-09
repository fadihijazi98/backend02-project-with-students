<?php

namespace CustomExceptions;

use Constants\ResponseStatusCodes;
use Constants\StatusCodes;
use Exception;
class ResourceNotFound extends Exception
{
    public function __construct()
    {

        parent::__construct("Resource is not found!!", ResponseStatusCodes::NOT_FOUND, null);
    }

}