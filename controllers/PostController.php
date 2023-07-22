<?php

namespace Controllers;

use Constants\Rules;
use Helpers\RequestHelper;
use Models\Post;

class PostController extends BaseController
{
    protected array $validationSchema =
        [
            "index"=>
            [
                "url"=>
                [
                  "userId"=>[Rules::INTEGER]
                ]
            ],

            "create"=>
            [
                "url"=>
                    [
                        "userId"=>[Rules::INTEGER]
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
            ],

            "update"=>
                [
                "url"=>
                    [

                    "postId"=>[Rules::INTEGER],

                    ],

                "payload"=>
                    [

                    "content"=>[Rules::STRING,
                                         Rules::REQUIRED]

                    ]
            ]

        ];
    protected function index($userId)
    {
        $limit = key_exists("limit",$_GET) ? $_GET["limit"] : 10;

        $currentPage = key_exists("page",$_GET) ? $_GET["page"] : 1;

        return Post::query()->
        where("user_id",$userId)->
        paginate($limit,["id","content","created"],"page",$currentPage)->
        items();
    }

    protected function create($userId)
    {
        $user =  User::query()->find($userId);

        if (! $user)
        {
            throw new ResourceNotFound();
        }

        $payload = RequestHelper::getRequestPayload();

        $post = $user->posts()->create
        (
            [
                "content"=>$payload["content"]
            ]
        );

        return ["message"=>"A new post with id = ".$post->id." has been added successfully :)"];

    }

    protected function update($postId)
    {

        $post = Post::query()->find($postId);

        if (! $post)
        {
            throw new ResourceNotFound();
        }

        $payload = RequestHelper::getRequestPayload();

        $post->update
        (
            [
            "content"=>$payload["content"]
            ]
        );

        return ["message"=>"A post with id = ".$post->id." has been updated successfully :)"];

    }


    protected function delete($postId)
    {

        $post = Post::query()->find($postId);

        if (! $post)
        {
            throw new ResourceNotFound();
        }

        $post->delete();

        return ["message"=>"A post with id = ".$post->id." has been deleted successfully :)"];
    }

}