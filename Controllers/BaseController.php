<?php
namespace Controllers;

abstract class BaseController {
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

        return ["data" => $this->$handler(... $arguments)];
    }

}
