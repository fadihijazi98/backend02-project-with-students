<?php

namespace Controller;

use constants\constant;
use component\Validator;
use helpers\RequestHelper;

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



private $validator;
public function __construct(){
    $this->validator=new Validator();
}




    protected function __call($method,$arguments){

        $arguments=$arguments[0];

        $handler=(key_exists($method,$this->handlerMap))?$this->handlerMap[$method]:$method;
        if (!method_exists($this,$handler)){
            return ["message"=>"no ".$handler ." defined as handler "];
        }

         $schema=[];


        if (key_exists($handler,$this->validationSchema)){
            $schema=$this->validationSchema;
        }

        // validate url variables

        if (key_exists(constant::URL,$schema[$handler])){

            $this->validator->validateUrlVariables($schema[$handler][constant::URL],$arguments,"url variables level ");
        }

        //validate query params

        if (key_exists(constant::QUERY,$schema[$handler])){

            $values=$_GET;
            $this->validator->validateQueryParams($schema[$handler][constant::QUERY],$values,"query params level ");
        }

        //validate payload data

        if (key_exists(constant::PAYLOAD,$schema[$handler])){

            $this->validator->validatePayloadData($schema[$handler][constant::PAYLOAD],RequestHelper::getRequestPayload()," payload data level ");
        }



        return["data"=>  $this->$handler(...$arguments )];
    }
}



