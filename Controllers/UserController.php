<?php

namespace Controller;

use helpers\RequestHelper;

class UserController extends BaseController
{
    /*
        * [GET/user] index()-> get the list of resources
        * [GET/user/{id}]  git resource by id
        *[POST/user] create mew resource
        *[PUT/user/{id}] update resource by id
     * [DELETE/user/{id}] delete resource by id
        * */

    protected static function index()
    {
        return [[

            "id" => "1",
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

    protected static function show($id)
    {
        return " user data for #$id";
    }

    protected static function create()
    {
        $data=RequestHelper::getRequestPayload();
        return " create new user has phone : ". $data["phone"];
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