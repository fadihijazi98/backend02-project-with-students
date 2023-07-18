<?php
namespace Controllers;
use Components\Validator;
use Helpers\RequestHelper;
use Models\User;
abstract class BaseController {

    protected $validationSchema=[];
    private $validator;

    public function __construct()
    {
        $this->validator = new Validator();
    }

    protected array $handlerMap = [
        'GET' => 'index',
        'POST' => 'create',
        'PUT' => 'update',
        'DELETE' => 'delete'
        ];

    public function __call($method, $arguments)
    {

        $arguments = $arguments[0];
        $handler = key_exists($method, $this->handlerMap) ? $this->handlerMap[$method] : $method;

        if (! method_exists($this, $handler)) {

            return "no " . $handler . " defined as handler";
        }
        $handlerSchema=[];

        if(key_exists($handler,$this->validationSchema)){
            $handlerSchema = $this->validationSchema[$handler];
        }
        if (key_exists("url",$handlerSchema)){
            $this->validator->validateUrlVariables($handlerSchema["url"],$arguments);
        }
        if (key_exists("query",$handlerSchema)){
            $this->validator->validateQueryParams($handlerSchema["query"],$_GET);
        }
        if (key_exists("payload",$handlerSchema)){
            $this->validator->validateRequestPayload($handlerSchema["payload"],RequestHelper::getRequestPayload());
        }
        $argumentValues = array_values($arguments);
        return ["data" => $this->$handler(... $arguments)];
    }

}
