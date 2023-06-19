<?php

namespace Controllers;

class PostController extends BaseController
{
    protected $validationSchema =[
        "create"=>[

            "url"=>[
                "userId" => ["integer"]
            ],
            "query"=>[
                "content_is_html"=>["boolean"]
            ],
            "payload"=>[
                "content"=>["required","string"]
            ]
        ]
    ];
protected function create($userId){
    return [
        "message"=>"created"
    ];
}
}