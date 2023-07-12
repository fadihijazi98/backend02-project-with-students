<?php

namespace Controllers;
use Constants\Rules;
use Models\Post;

class PostController extends BaseController
{
    protected $validationSchema =[
        "create"=>[

            "url"=>[
                "userId" => [Rules::INTEGER]
            ],
            "query"=>[
                "content_is_html" => [Rules::BOOLEAN]
            ],
            "payload"=>[
                "content" => [
                    Rules::REQUIRED,
                    Rules::STRING,
                    Rules::UNIQUE => ["model"=> Post::class]
                ]
            ]
        ]
    ];
protected function create($userId){
    return [
        "message"=>"created"
    ];
}
}