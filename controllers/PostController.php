<?php

namespace Controllers;

class PostController extends BaseController
{
    protected array $validationSchema =
        [
            "create"=>
            [
                "url"=>
                [
                  "userId"=>["Integer"]
                ],
                "query"=>
                [
                    "contentIsHtml"=>["Boolean"]
                ],
                "payload"=>
                [
                    "content"=>["Required","String"]
                ]
            ]

        ];
    protected function create(): array
    {
        return ["message"=>"A new post is been created dear user :)"];
    }

}