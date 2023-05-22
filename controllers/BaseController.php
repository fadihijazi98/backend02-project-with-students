<?php
namespace Controllers;

abstract class BaseController {

    /**
     * in MVC
     * Controller provide 5 methods
     *      - [GET /users]: index() -> get list of resources
     *      - [GET /resources/{id}]: show($id) -> get one resource
     *      - [POST /resource]: create() -> create new resource in datastore
     *      - [PUT /resource/{id}]: update($id) -> update data of some resource (match by $id)
     *      - [DELETE /resource/{id}]: delete($id) -> delete some resource (match by $id)
     */
    protected $handlerMap = [
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