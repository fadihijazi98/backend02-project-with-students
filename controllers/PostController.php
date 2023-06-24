<?php

namespace Controllers;

use Constants\Rules;

class PostController extends BaseController
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
                "content" => [Rules::REQUIRED, Rules::STRING]
            ]
        ],
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
    protected function create($userId) {

        return [
            "message" => "created"

        ];
    }
}