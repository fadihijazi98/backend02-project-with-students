<?php

namespace Controllers;

 use Components\Validator;
 use Helpers\RequestHelper;

 abstract class BaseController
{
    protected array $validationSchema = [];
    //It's an empty array to let subclasses modify it as needed

     private $validator;

     public function __construct()
     {
         $this->validator = new Validator();
     }
    protected array $handlerMap =
    [
        "GET"=>"index",
        "POST"=>"create",
        "PUT"=>"update",
        "DELETE"=>"delete"
    ];

    /*
          * 1.With the last code statement, if the handler was defined as private
          * recursion will occur because of calling __call method frequently
          * since handler is private ,and we can't access it from outside
          * class where it were defined, so we define all handlers as protected
          *
          * 2.The value of $method will be the value of custom handler if it's not
          * null,but if it's null,the value will be the value of current request method
          * then we will get the handler that associated with it
          *
          * 3.Remember that the used operation above is called ternary operation
          * which checks the value of a condition if it's true of false,
          * if it's true,compiler will execute code statement that is after the ?,
          * otherwise (the condition is false), code statement after : will be executed
          *
          * 4.Note that if the custom handler was null, the value of request method will still
          * the same and the value of $handler will be one of the 4 values registered in the
          * handlerMap array
  */
    public function __call($method,$arguments)
    {
        $handler = key_exists($method,$this->handlerMap) ? $this->handlerMap[$method] : $method;

        $arguments = $arguments[0];

        $handlerSchema = [];

        if(key_exists($handler,$this->validationSchema))
        {
            $handlerSchema = $this->validationSchema[$handler];
        }

        if(key_exists("url",$handlerSchema))
        {
            $this->validator->validateUrlVariables($handlerSchema["url"],$arguments);
        }

        if(key_exists("query",$handlerSchema))
        {
            $this->validator->validateQueryParameters($handlerSchema["query"],$_GET);
        }

        if(key_exists("payload",$handlerSchema))
        {
            $this->validator->validateRequestPayload($handlerSchema["payload"],RequestHelper::getRequestPayload());
        }

        if(!method_exists($this,$handler))
        {
            return "No".$handler."is defined unfortunately :(";
        }
        $argumentValues = array_values($arguments);
        return ["data"=>$this->$handler(...$argumentValues)];

    }
}
