<?php

namespace Controller;

use constants\Rules;
use helpers\RequestHelper;
use http\Url;
use Models\Posts;
use customException\SourceNotFound;
use Exception;
use Models\User;

class PostController extends BaseController
{
    protected $validationSchema = [
        "index" => [
            "url" => [
                "userId" => [Rules::INTEGER]
            ],
            "query" => [
                "limit" => [Rules::INTEGER],
                "page" => [Rules::INTEGER]
            ]
        ], "create" => [
            "url" => [
                "userId" => [Rules::INTEGER]
            ],
            "payload" => [
                "content" => [
                    Rules::REQUIRED, Rules::STRING]

            ]
        ], "show" => [
            "url" => [
                "postId" => [Rules::REQUIRED, Rules::INTEGER]
            ]
        ],"update"=>[
            "url"=>[
                "postId"=>[Rules::REQUIRED,Rules::INTEGER]
            ],
            "payload"=>[
                "content"=>[Rules::REQUIRED,Rules::STRING]
            ]
        ],"delete"=>[
            "url"=>[
                "postId"=>[Rules::REQUIRED,Rules::INTEGER]
            ]
        ]


    ];

    protected function index($userId)
    {


        $current_page = key_exists('page', $_GET) ? $_GET['page'] : 1;
        $limit = key_exists('limit', $_GET) ? $_GET['limit'] : 2;
        $posts = Posts::query()
            ->where('user_id', $userId)
            ->paginate($limit, ['id', 'content', 'created'], 'page', $current_page)
            ->items();

        return $posts;

    }

    protected function show($postId)
    {

        $post = Posts::query()->find($postId);
        return $post;
    }

    protected function create($userId)
    {
        $user = User::query()->find($userId);
        $payload = RequestHelper::getRequestPayload();
        if (!$user) {
            throw new SourceNotFound();
        }
        $user->posts()->create([
            "content" => $payload['content']
        ]);

        return ["message" => "post created within id ##$user->id"];

    }

    protected function update($postId)
    {
        $post = Posts::query()->find($postId);
        $payload = RequestHelper::getRequestPayload();
        if (!$post){
            throw new SourceNotFound();
        }
        Posts::query()->find($postId)->update([
                "content" => $payload['content']
            ]
        );

        return ["message " => "post updated "];


    }

    protected function delete($postId)
    {
        if (!Posts::query()->exists($postId)){
            throw new SourceNotFound();
        }
        Posts::query()->find($postId)->delete();
        return ["message " => "post deleted "];

    }

}