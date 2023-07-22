<?php

namespace Controllers;

use Constants\Rules;
use Models\Post;

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
                    "content"=>
                        [Rules::REQUIRED,
                            Rules::STRING,
                                Rules::UNIQUE=>
                                               [
                                                "model"=>Post::class
                                               ]
                        ]
                ]
            ]

        ];
    protected function create(): array
    {
        return ["message"=>"A new post is been created dear user :)"];
    }

}