<?php

namespace Controllers;

 abstract class BaseController
{
    protected abstract function index();
    protected abstract function show($id);
    protected abstract function create($id);
    protected abstract function update($id,$id2);
    protected abstract function delete($id,$id2);

    protected array $handlerMap =
    [
        "GET"=>"index",
        "POST"=>"create",
        "PUT"=>"update",
        "DELETE"=>"delete"
    ];

    public function __call($method,$arguments)
    {
        $handler = key_exists($method,$this->handlerMap) ? $this->handlerMap[$method] : $method;

        if(!method_exists($this,$handler))
        {
            return "No".$handler."is defined unfortunately :(";
        }

        return ["data"=>$this->$handler(...$arguments)];

    }

}
