<?php

namespace Controller;

use constants\Rules;
use helpers\RequestHelper;
use Models\User;
use customException\SourceNotFound;
use Exception;

class UserController extends BaseController
{


    protected $validationSchema = [
        'create' => [
            "payload" => [
                "name" => [Rules::REQUIRED, Rules::STRING],
                "userName" => [Rules::REQUIRED, Rules::STRING],
                "email" => [Rules::REQUIRED, Rules::STRING],
                "profile_img" => [Rules::STRING],
                "password" => [Rules::REQUIRED, Rules::STRING]
            ]
        ],
        "update" => [
            "payload" => [
                "name" => [Rules::STRING],
                "userName" => [Rules::STRING],
                "email" => [Rules::STRING],
                "profile_img" => [Rules::STRING],
                "password" => [Rules::STRING]

            ]
        ]
    ];


    /*
     * [GET/user] index()-> get the list of resources
     * [GET/user/{id}]  git resource by id
     *[POST/user] create mew resource
     *[PUT/user/{id}] update resource by id
     * [DELETE/user/{id}] delete resource by id
     */

    protected function index()
    {
        $users = User::all();
        return $users;
    }

    protected function show($id)
    {
        $user = User::query()->find($id);
        if (!$user) {
            throw new SourceNotFound();
        }
        return $user;
    }

    protected function create()
    {
        $payload = RequestHelper::getRequestPayload();
        $payload['password'] = md5($payload['password']);

        $user = User::create($payload);

        return [
            "id" => $user->id
        ];
    }

    protected function update($id)
    {
        $payload = RequestHelper::getRequestPayload();
        if ($payload['password']) {
            throw new Exception("password can't be update by this API.");
        }

        $user = $this->show($id);
        $user->update($payload);

        return [
            "message" => "update "
        ];

    }

    protected function delete($id)
    {
        $payload = RequestHelper::getRequestPayload();

        $user = $this->show($id);
        $user->delete($payload);

        return [
            "message" => "deleted "
        ];

    }

}




