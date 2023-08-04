<?php

namespace Controllers;
use Constants\Rules;
use CustomExceptions\ResourceNotFound;
use Helpers\RequestHelper;
use Helpers\ResourceHelper;
use CustomExceptions\BadRequestException;
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
                "content" => [Rules::STRING, Rules::REQUIRED]
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

    /**
     * @throws ResourceNotFound
     */
    protected function index($userId)
    {
        $limit = key_exists("limit", $_GET) ? $_GET["limit"] : 10;
        $current_page = key_exists("page", $_GET) ? $_GET["page"] : 1;

        $user = ResourceHelper::findResourceOr404Exception(User::class,$userId);

        $posts =$user
            ->posts
            ->with(['user:id,name,profile_img', 'likes', 'comments','comments.user:id,name,profile_img'])
            ->paginate($limit, ["id", "content", "created", "user_id"], "page", $current_page)
            ->items();


        return ResourceHelper::loadOnlyForList(
            ["id", "content", "created", "publisher_user", "likes_count", "recent_likes", "comments_count", "recent_comments"],
            $posts
        );

    }


    protected function show($postId)
    {
        $post = ResourceHelper::findResourceOr404Exception(
            Post::class,
            $postId
            ,['user:id,name,profile_img', 'likes', 'comments','comments.user:id,name,profile_img']);


        return ResourceHelper::loadOnly(
            ["id", "content", "created", "publisher_user", "likes_count", "recent_likes", "comments_count", "recent_comments"],
            $post);
    }

    /**
     * @throws ResourceNotFound
     */
    protected function create($userId)
    {

        $user = ResourceHelper::findResourceOr404Exception(User::class, $userId);

        $payload = RequestHelper::getRequestPayload();

        $post = $user->posts()->create([
            "content" => $payload["content"]
        ]);

        return ["message" => "post has been successfully created  within id = $post->id "];

    }

    /**
     * @throws ResourceNotFound
     */
    protected function update($postId)
    {

        $post = ResourceHelper::findResourceOr404Exception(Post::class, $postId);

        $payload = RequestHelper::getRequestPayload();
        $post->update($payload);

        return ["message" => "post within id #$post->id has been updated successfully"];


    }

    /**
     * @throws ResourceNotFound
     */
    protected function delete($postId)
    {

        $post = ResourceHelper::findResourceOr404Exception(Post::class, $postId);

        $post->delete();
        return ["message" => "post  has been deleted successfully"];
    }

    /**
     * @throws BadRequestException
     * @throws ResourceNotFound
     */
    protected function like($userId, $postId)
    {

        $post = ResourceHelper::findResourceOr404Exception(Post::class, $postId);
        $user = ResourceHelper::findResourceOr404Exception(Like::class, $userId);

        $is_like_exists = Like::query()
            ->where('user_id', $user->id)
            ->where('post_id', $post->id)
            ->exists();

        if ($is_like_exists) {

            throw new BadRequestException("this user (" . $user->username . ") is already like the post.");
        }

        Like::create([
            "user_id" => $user->id,
            "post_id" => $post->id
        ]);

        return ["message" => "User (" . $user->username . ") like the post that have (" . $post->content . ") as content."];

    }

    /**
     * @throws BadRequestException
     * @throws ResourceNotFound
     */
    protected function unLike($userId, $postId)
    {

        $user = ResourceHelper::findResourceOr404Exception(User::class, $userId);
        $post = ResourceHelper::findResourceOr404Exception(Post::class, $postId);

        $like = Like::query()
            ->where('user_id', $user->id)
            ->where('post_id', $post->id)
            ->first();

        if ($like == null) {

            throw new BadRequestException("this user (" . $user->username . ") should be liked the post first to remove his like.");
        }

        $like->delete();
        return ["message" => "User (" . $user->username . ") un-like the post that have (" . $post->content . ") as content."];

    }
}
