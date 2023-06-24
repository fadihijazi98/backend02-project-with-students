<?php
namespace Controllers;

use Components\Validator;
use Helpers\RequestHelper;

abstract class BaseController{

    protected $methodMap=[
        "GET"=>'index',
        "POST"=>"create",
        "PUT"=>"update",
        "DELETE"=>"delete"
    ];

    protected $validationSchema = [];

    private $validator;

    public function __construct()
    {
        $this->validator = new Validator();
    }

    public function __call($method, $arguments){
        $arguments = $arguments[0];

        $handler = key_exists($method, $this->methodMap) ? $this->methodMap[$method] : $method;
        if(! method_exists($this, $handler)){
            return "no". $handler ."defined as handler !!";
        }

        $handlerSchema = [];
        if (key_exists($handler, $this->validationSchema)) {

            $handlerSchema = $this->validationSchema[$handler];
        }

        // validate url variables
        if (key_exists("url", $handlerSchema)) {

            $this->validator->validateUrlVariables($handlerSchema["url"], $arguments);
        }
        // validate query params
        if (key_exists("query", $handlerSchema)) {

            $this->validator->validateQueryParams($handlerSchema["query"], $_GET);
        }
        // validate request payload
        if (key_exists("payload", $handlerSchema)) {
            $r=RequestHelper::getRequestPayload();
            
            $this->validator->validateRequestPayload($handlerSchema["payload"], $r);
        }

        $argumentValues = array_values($arguments);
        return ["data" => $this->$handler(... $argumentValues)];
    }
}