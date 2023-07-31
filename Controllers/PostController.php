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
        $user = ResourceHelper::findResourceOr404Exception(User::class,$userId);
        $posts = Post::query()->where('user_id',$userId)->get();

        $post_of_user= [];

        foreach ($posts as $post){
            $post_of_user[] = $this->show($post->id);
        }
        return $post_of_user;

    }


    protected function show($postId)
    {
        $post = Post::query()->with(['user:id,name,profile_img', 'likes', 'comments'])->find($postId);

        if ($post == null) {
            throw new ResourceNotFound();
        }
        $response = [
            'id' => $post->id,
            'content'=> $post->content,
            'created'=> $post->created,
            'publisher_user'=>$post->user,
            'likes_count'=>$post->likes->count(),
            'comments_count'=>$post->comments->count()
        ];

        $recent_likes =[];
        $recent_comments = [];

        foreach ($post->likes->sortByDesc('created') as $like){

            $recent_likes[] = $like->user->name;

            if(sizeof($recent_likes)==2){
                break;
            }
        }

        foreach ($post->comments->sortByDesc('created') as $comment){

            $recent_comments[] = [
                'id' => $comment->id,
                'content'=> $comment->content,
                'created'=> $comment->created,
                'user'=>[
                    'id' => $comment->user->id,
                    'name'=> $comment->user->name,
                    'avatar'=> $comment->user->profile_img
                ]
            ];

            if(sizeof($recent_comments)== 5){
                break;
            }
        }
            $response['recent_comments']=$recent_comments;
            $response['recent_likes']=$recent_likes;



        return $response;
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
