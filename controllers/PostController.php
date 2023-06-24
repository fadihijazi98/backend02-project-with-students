<?php

namespace Controllers;

use Constants\Rules;

class PostController extends BaseController
{
    protected array $validationSchema =
        [
            "create"=>
            [
                "url"=>
                [
                  "userId"=>[Rules::INTEGER]
                ],
                "query"=>
                [
                    "contentIsHtml"=>[Rules::BOOLEAN]
                ],
                "payload"=>
                [
                    "content"=>[Rules::REQUIRED,Rules::STRING]
                ]
            ]

        ];
    protected function create(): array
    {
        return ["message"=>"A new post is been created dear user :)"];
    }

}