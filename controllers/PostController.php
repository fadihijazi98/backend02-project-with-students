<?php

namespace Controllers;

use Constants\Rules;
use Controllers\BaseController;

class PostController extends BaseController{
    protected $validationSchema = [
        "create" => [
            "url" => [
                "user_id" => [Rules::INTEGER]
            ],
            "query" => [
                "content_is_html" => [Rules::BOOLEAN]
            ],
            "payload" => [
                "content" => [Rules::REQUIRED, Rules::STRING],
            ]
        ]
    ];

    /**
     * POST /users/{id}/posts
     * excepted:
     *      - {id} is integer (url variable)
     *      - ?is_html is boolean (query params)
     *      - content is string (payload)
     *
     * @param $userId
     * @return string[]
     */
    protected function create($user_id) {

        return [
            "message" => "user $user_id created a new post!"

        ];
    }
}