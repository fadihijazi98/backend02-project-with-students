<?php
namespace Controllers;

use Components\Validator;
use Helpers\RequestHelper;

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

    /**
     * [
     *   handler => [
     *      "url" => [
     *          "key' => [... Rules]
     *      ],
     *      "query" => [
     *          "key" => [... Rules]
     *      ],
     *      "payload" => [
     *          "key" => [... Rules]
     *      ]
     *   ]
     * ]
     * @var array $validationSchema (associative array)
     */
    protected $validationSchema = [];

    private $validator;

    public function __construct()
    {
        $this->validator = new Validator();
    }

    public function __call($method, $arguments)
    {

        $arguments = $arguments[0];

        $handler = key_exists($method, $this->handlerMap) ? $this->handlerMap[$method] : $method;// "create"

        if (! method_exists($this, $handler)) {

            return "no " . $handler . " defined as handler";
        }

        $handlerSchema = [];
        if (key_exists($handler, $this->validationSchema)) {

            $handlerSchema = $this->validationSchema[$handler];
        }

        // validate url variables
        if (key_exists("url", $handlerSchema)) {

            $this->validator->validateUrlVariables($handlerSchema["url"], $arguments); // [10]
        }
        // validate query params
        if (key_exists("query", $handlerSchema)) {

            $this->validator->validateQueryParams($handlerSchema["query"], $_GET);
        }
        // validate request payload
        if (key_exists("payload", $handlerSchema)) {

            $this->validator->validateRequestPayload($handlerSchema["payload"], RequestHelper::getRequestPayload());
        }

        $argumentValues = array_values($arguments);
        return ["data" => $this->$handler(... $argumentValues)];
    }
}