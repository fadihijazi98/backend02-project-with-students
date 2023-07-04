<?php

namespace Controller;

abstract class  BaseController
{

    /*
     * in MVC Model
     *
     * Controller provide 5 methode
     *
     *          ********** handler  ************
     *
     *        -[GET/users] index() -> get list of user
     *        -[GET/users/{id}]  show(id) -> get one resource
     *        -[POST/users]  create()  -> create new resource in datastore
     *        -[PUT/users/{id}] update(id)  -> update data of some resource (match by id )
     *        -[DELETE/users/{id}]  delete(id) -> delete some resource (match by id)
     *
     *
     * */


    protected $handlerMap = [
        "GET" => "index",
        "POST" => "create",
        "PUT" => "update",
        "DELETE" => "delete"
    ];



    protected function __call($method,$arguments){
        $handler=$this->handlerMap[$method];
        if (!method_exists($this,$handler)){
            return "no ".$handler ." defined as handler ";
        }
        return  $this->$handler(...$arguments );
    }
}



