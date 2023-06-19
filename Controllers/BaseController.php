<?php
namespace Controllers;
use Components\Validator;
use Helpers\RequestHelper;
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

        $handler = key_exists($method,$this->handlerMap) ? $this->handlerMap[$method] : $method;

        if (! method_exists($this, $handler)) {

            return "no " . $handler . " defined as handler";
        }
        $handlerSchema=[];

        if(key_exists($handler,$this->validationSchema)){
            $handlerSchema = $this->validationSchema[$handler];
        }
        if (key_exists("url",$handlerSchema)){
            $this->validator->ValidateUrlVariables($handlerSchema["url"],$arguments);
        }
        if (key_exists("query",$handlerSchema)){
            $this->validator->ValidateQueryParams($handlerSchema["query"],$_GET);
        }
        if (key_exists("payload",$handlerSchema)){
            $this->validator->ValidateRequestPayload($handlerSchema["payload"],RequestHelper::getRequestPayload());
        }
        return ["data" => $this->$handler(... $arguments)];
    }

}
