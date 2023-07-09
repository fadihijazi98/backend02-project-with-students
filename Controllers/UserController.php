<?php

namespace Controller;

use helpers\RequestHelper;
use constants\constant;

class UserController extends BaseController
{


    protected $validationSchema = [
        "create" => [

            "url" => [
                "userId" => [constant::INTEGER]
            ],
            "query" => [
                "content_is_html" => [constant::BOOLEAN]
            ],
            "payload" => [
                "userId" => [constant::INTEGER],
                "userName" => [constant::STRING],
                "email" => [constant::STRING],
                "phone" => [constant::STRING, constant::REQUIRED],
                "isAdmin" => [constant::BOOLEAN]
            ]
        ],
        "show" => [

            "url" => [
                "userId" => [constant::INTEGER,constant::REQUIRED],
                "postId"=>[constant::INTEGER]
            ],
            "query" => [
                "content_is_html" => [constant::BOOLEAN]
            ],
            "payload" => [
                "userId" => [constant::INTEGER],
                "userName" => [constant::STRING],
                "email" => [constant::STRING],
                "phone" => [constant::STRING, constant::REQUIRED],
                "isAdmin" => [constant::BOOLEAN]
            ]



        ]
    ];


    /*
        * [GET/user] index()-> get the list of resources
        * [GET/user/{id}]  git resource by id
        *[POST/user] create mew resource
        *[PUT/user/{id}] update resource by id
     * [DELETE/user/{id}] delete resource by id
        * */


    protected static function index($id)
    {
        return [[
            "id" => $id,
            "name" => "saleh",
            "email" => "saleh@gmail.com"
        ],
            [
                "id" => "2",
                "name" => "mhmd",
                "email" => "mhmd@gmail.com"

            ]
        ];
    }

    protected static function show($userId, $postId)
    {
        return " user #$userId like post #$postId";
    }

    protected static function create($userID)
    {
        $data = RequestHelper::getRequestPayload();
        return " create new user has phone : " . $data["phone"] . "     #$userID";
    }

    protected static function update($id)
    {
        return "user #$id update successfully";
    }

    protected static function delete($id)
    {
        return "user #$id delete successfully";
    }

    protected static function like($id)
    {
        return " user  #$id" . " liked saleh post ";
    }

}