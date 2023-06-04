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

        $handler = $this->handlerMap[$method];

        if (! method_exists($this, $handler)) {

            return "no " . $handler . " defined as handler";
        }

        return $this->$handler(... $arguments);
    }

}
