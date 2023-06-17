<?php

namespace Controllers;

class PostController extends BaseController
{
    protected $validationSchema = [
        "create" => [
            "url" => [
                "userId" => ["integer"]
            ],
            "query" => [
                "content_is_html" => ["boolean"]
            ],
            "payload" => [
                "content" => ["required", "string"]
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
    protected function create($userId) {

        return [
            "message" => "created"

        ];
    }
}