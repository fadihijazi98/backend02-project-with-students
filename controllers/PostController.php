<?php

namespace Controllers;

use Constants\Rules;
use CustomExceptions\BadRequestException;
use CustomExceptions\ResourceNotFound;
use Helpers\RequestHelper;
use Helpers\ResourceHelper;
use Models\Like;
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
        ],
        "update" => [
            "url" => [
                "postId" => [Rules::INTEGER]
            ],
            "payload" => [
                "content" => [Rules::STRING]
            ]
        ],
        "like" => [
            "url" => [
                "userId" => [Rules::REQUIRED, Rules::INTEGER],
                "postId" => [Rules::INTEGER]
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

        $user = ResourceHelper::findResourceOr404Exception(User::class, $userId);

        $payload = RequestHelper::getRequestPayload();
        $post = $user->posts()->create([
            "content" => $payload["content"]
        ]);

        return ["message" => "post created within id #" . $post->id];
    }

    protected function update($postId) {

        $post = ResourceHelper::findResourceOr404Exception(Post::class, $postId);

        $payload = RequestHelper::getRequestPayload();
        $post->update($payload);

        return ["message" => "post has been successfully updated."];
    }

    protected function delete($postId) {

        ResourceHelper::findResourceOr404Exception(Post::class, $postId)->delete();
        return ["message" => "post has been successfully deleted."];
    }

    protected function like($userId, $postId) {

        $user = ResourceHelper::findResourceOr404Exception(User::class, $userId);
        $post = ResourceHelper::findResourceOr404Exception(Post::class, $postId);

        $isLikeExists = Like::query()->where("user_id", $user->id)->where("post_id", $post->id)->exists();
        if ($isLikeExists) {

            throw new BadRequestException("this user (" . $user->username . ") is already like the post.");
        }

        Like::create([
            "user_id" => $user->id,
            "post_id" => $post->id
        ]);

        return ["message" => "User (" . $user->username . ") like the post that have (" . $post->content . ") as content."];
    }

    protected function unLike($userId, $postId) {

        $user = ResourceHelper::findResourceOr404Exception(User::class, $userId);
        $post = ResourceHelper::findResourceOr404Exception(Post::class, $postId);

        $like = Like::query()->where("user_id", $user->id)->where("post_id", $post->id)->first();
        if ($like == null) {

            throw new BadRequestException("this user (" . $user->username . ") should be liked the post first to remove his like.");
        }

        $like->delete();
        return ["message" => "User (" . $user->username . ") un-like the post that have (" . $post->content . ") as content."];
    }
}