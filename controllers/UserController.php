<?php
namespace Controllers;

use Constants\Rules;
use CustomExceptions\BadRequestException;
use CustomExceptions\ResourceNotFound;
use Helpers\RequestHelper;
use Models\User;

class UserController extends BaseController {

    protected $validationSchema = [
        "create" => [
            "payload" => [
                "name" => [Rules::REQUIRED, Rules::STRING],
                "email" => [
                    Rules::REQUIRED,
                    Rules::STRING,
                    Rules::UNIQUE => [
                        "model" => User::class
                    ]
                ],
                "username" => [
                    Rules::REQUIRED,
                    Rules::STRING,
                    Rules::UNIQUE => [
                        "model" => User::class
                    ],
                ],
                "password" => [Rules::REQUIRED, Rules::STRING],
                "profile_image" => [Rules::STRING],
            ]
        ],
        "update" => [
            "payload" => [
                "name" => [Rules::STRING],
                "email" => [
                    Rules::STRING,
                    Rules::UNIQUE => [
                        "model" => User::class
                    ]
                ],
                "username" => [
                    Rules::STRING,
                    Rules::UNIQUE => [
                        "model" => User::class
                    ]
                ],
                "profile_image" => [Rules::STRING],
            ]
        ]
    ];

    protected function index() {

        return User::all("id", "username", "profile_image");
    }

    protected function show($id) {

        $user =  User::query()->find($id);
        if (! $user) {

            throw new ResourceNotFound();
        }

        return $user;
    }

    protected function create() {

        $payload = RequestHelper::getRequestPayload();
        $payload["password"] = md5($payload["password"]);

        $user = User::create($payload);
        return [
            "id" => $user->id
        ];
    }

    protected function update($id) {

        $payload = RequestHelper::getRequestPayload();
        if (key_exists("password", $payload)) {

            throw new BadRequestException("Password can't be update by this API.");
        }

        $user = $this->show($id);
        $user->update($payload);

        return [
            "message" => "updated."
        ];
    }

    protected function delete($id) {

        $user =  $this->show($id);
        $user->delete();

        return [
            "message" => "deleted."
        ];
    }
}