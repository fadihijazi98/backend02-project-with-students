<?php

namespace Controller;

use helpers\RequestHelper;
use constants\Rules;

class UserController extends BaseController
{


    protected $validationSchema = [
        "create" => [

            "url" => [
                "userId" => [Rules::INTEGER]
            ],
            "query" => [
                "content_is_html" => [Rules::BOOLEAN]
            ],
            "payload" => [
                "userId" => [Rules::INTEGER],
                "userName" => [Rules::STRING],
                "email" => [Rules::STRING],
                "phone" => [Rules::STRING, Rules::REQUIRED],
                "isAdmin" => [Rules::BOOLEAN]
            ]
        ],
        "show" => [

            "url" => [
                "userId" => [Rules::INTEGER,Rules::REQUIRED],
                "postId"=>[Rules::INTEGER]
            ],
            "query" => [
                "content_is_html" => [Rules::BOOLEAN]
            ],
            "payload" => [
                "userId" => [Rules::INTEGER],
                "userName" => [Rules::STRING],
                "email" => [Rules::STRING],
                "phone" => [Rules::STRING, Rules::REQUIRED],
                "isAdmin" => [Rules::BOOLEAN]
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