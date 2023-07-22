<?php
namespace Controllers;

use Constants\Rules;
use Helpers\RequestHelper;
use Helpers\ResourceHelper;
use Models\Comment;
use Models\Post;
use Models\User;

class CommentController extends BaseController
{

    protected $validationSchema = [
        "create" => [
            "url" => [
                "userId" => [Rules::INTEGER],
                "postId" => [Rules::INTEGER]
            ],
            "payload" => [
                "content" => [Rules::REQUIRED, Rules::STRING]
            ]
        ],
        "update" => [
            "payload" => [
                "content" => [Rules::REQUIRED, Rules::STRING]
            ]
        ]
    ];

    protected function create($userId, $postId) {

        $user =  ResourceHelper::findResourceOr404Exception(User::class, $userId);
        $post = ResourceHelper::findResourceOr404Exception(Post::class, $postId);

        $payload = RequestHelper::getRequestPayload();
        $payload["user_id"] = $user->id;
        $payload["post_id"] = $post->id;

        Comment::create($payload);

        return ["message" => "comment has been successfully created."];
    }

    protected function update($commentId) {

        $comment = ResourceHelper::findResourceOr404Exception(Comment::class, $commentId);
        $payload = RequestHelper::getRequestPayload();

        $content = $payload['content'];
        $comment->update([
           "content" => $content
        ]);
        return ["message" => "comment has been successfully updated."];
    }
}
