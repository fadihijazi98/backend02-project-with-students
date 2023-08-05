<?php
namespace Controllers;

use Constants\Rules;
use CustomExceptions\BadRequestException;
use CustomExceptions\UnAuthorizedException;
use Helpers\RequestHelper;
use Helpers\ResourceHelper;
use Mixins\AuthenticateUser;
use Models\User;

class UserController extends BaseController {
    use AuthenticateUser;

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

    public function __construct()
    {
        $this->skipHandlers = ["index", "show", "create"];
        parent::__construct();
    }

    protected function index() {

        $limit = key_exists("limit", $_GET) ? $_GET["limit"] : 10;
        $current_page = key_exists("page", $_GET) ? $_GET["page"] : 1;

        $paginator = User::query()->paginate($limit, ["id", "username", "profile_image"], 'page', $current_page);
        return $paginator->items();
    }

    protected function show($id) {

        return ResourceHelper::findResourceOr404Exception(User::class, $id);
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

        $user = ResourceHelper::findResourceOr404Exception(User::class, $id);

        $this->authenticatedUser->validateIsUserAuthorizedTo($user, "id");

        $user->update($payload);

        return [
            "message" => "updated."
        ];
    }

    protected function delete($id) {

        $user =  ResourceHelper::findResourceOr404Exception(User::class, $id);
        $user->delete();

        return [
            "message" => "deleted."
        ];
    }
}