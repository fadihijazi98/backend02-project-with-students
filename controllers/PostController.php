<?php

namespace Controllers;

use Constants\Rules;
use CustomExceptions\BadRequestException;
use CustomExceptions\ResourceNotFound;
use Helpers\RequestHelper;
use Helpers\ResourceHelper;

use Mixins\AuthenticateUser;
use Models\Like;
use Models\Post;
use Models\User;

class PostController extends BaseController
{
    use AuthenticateUser;

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

    public function __construct()
    {
        $this->skipHandlers = ["show"];
        parent::__construct();
    }

    protected function index($userId)
    {

        $limit = key_exists("limit", $_GET) ? $_GET["limit"] : 10;
        $current_page = key_exists("page", $_GET) ? $_GET["page"] : 1;

        /**
         * @var User $user
         */
        $user = ResourceHelper::findResourceOr404Exception(User::class, $userId);
        $posts =
            $user
                ->posts()
                ->with(['user:id,name,profile_image', 'likes', 'comments', 'comments.user:id,name,name,profile_image'])
                ->paginate($limit, ["id", "content", "created", "user_id"], "page", $current_page)
                ->items();
        return ResourceHelper::loadOnlyForList(
            ["id", "content", "created", "publisher_user", "likes_count", "recent_likes", "comments_count", "recent_comments"],
            $posts
        );
    }

    protected function show($postId)
    {

        /**
         *  - name (publisher user)
         *  - avatar (publisher user)
         *  - date of post created (post)
         *  - content (post)
         *  - likes
         *      - 1. count of likes
         *      - 2. the last 2 users (if exists) names that made likes
         *  - comments:
         *      - 1. count of comments
         *      - 2. the last 5 (if exists) comments in the posts.
         *  [.]
         *  [Request] GET api/v1/posts/{postId}
         *  [Response] JSON
         *  {
         *      "id": int,
         *      "content": text,
         *      "created": date,
         *      "publisher_user": {
         *          "id": int,
         *          "name": string,
         *          "avatar": url
         *      },
         *      "likes_count": int,
         *      "recent_likes": [string, ...],
         *      "comments_like": int,
         *      "recent_comments": [
         *          {
         *              "id": int,
         *              "content": string,
         *              "created": string,
         *              "user": {
         *                  "id": int,
         *                  "name": string,
         *                  "avatar": url
         *              }
         *          }, ...
         *      ]
         *  }
         */

        $post = ResourceHelper::findResourceOr404Exception(
            Post::class,
            $postId,
            ['user:id,name,profile_image', 'likes', 'comments', 'comments.user:id,name,name,profile_image']
        );
        return ResourceHelper::loadOnly(
            ["id", "content", "created", "publisher_user", "likes_count", "recent_likes", "comments_count", "recent_comments"],
            $post
        );
    }

    protected function create($userId)
    {

        $user = ResourceHelper::findResourceOr404Exception(User::class, $userId);

        $payload = RequestHelper::getRequestPayload();
        $post = $user->posts()->create([
            "content" => $payload["content"]
        ]);

        return ["message" => "post created within id #" . $post->id];
    }

    protected function update($postId)
    {

        $post = ResourceHelper::findResourceOr404Exception(Post::class, $postId);

        $this->authenticatedUser->validateIsUserAuthorizedTo($post);

        $payload = RequestHelper::getRequestPayload();
        $post->update($payload);

        return ["message" => "post has been successfully updated."];
    }

    protected function delete($postId)
    {

        ResourceHelper::findResourceOr404Exception(Post::class, $postId)->delete();
        return ["message" => "post has been successfully deleted."];
    }

    protected function like($userId, $postId)
    {

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

    protected function unLike($userId, $postId)
    {

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