<?php

namespace Controllers;

use Constants\Rules;
use CustomExceptions\ResourceNotFound;
use Helpers\RequestHelper;
use Models\Post;
use Models\User;

class PostController extends BaseController
{
    protected $validationSchema = [
        "index" => [
            "url" => [
                "userId" => [Rules::INTEGER]
            ]
        ],
        "create" => [
            "url" => [
                "userId" => [Rules::INTEGER]
            ],
            "payload" => [
                "content" => [Rules::REQUIRED, Rules::STRING]
            ]
        ]
    ];

    protected function index($userId) {

        $limit = key_exists("limit", $_GET) ? $_GET["limit"] : 10;
        $current_page = key_exists("page", $_GET) ? $_GET["page"] : 1;

        return
            Post::query()
                ->where("user_id", $userId)
                ->paginate($limit, ["id", "content", "created"], "page", $current_page)
                ->items();
    }

    protected function show($postId) {

    }

    protected function create($userId) {

        $user = User::query()->find($userId);
        if (! $user) {

            throw new ResourceNotFound();
        }

        $payload = RequestHelper::getRequestPayload();
        $post = $user->posts()->create([
            "content" => $payload["content"]
        ]);

        return ["message" => "post creted within id #" . $post->id];
    }

    protected function update($postId) {

    }

    protected function delete($postId) {

    }
}