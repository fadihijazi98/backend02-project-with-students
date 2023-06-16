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
        $handler = $this->handlerMap[$method];

        if(!method_exists($this,$handler))
        {
            return "No".$handler."is defined unfortunately :(";
        }

        return $this->$handler(... $arguments);
        /*
         * With the last code statement, if the handler was defined as private
         * recursion will occur because of calling __call method frequently
         * since handler is private ,and we can't access it from outside
         * class where it were defined, so we define all handlers as protected
         */
    }

}
