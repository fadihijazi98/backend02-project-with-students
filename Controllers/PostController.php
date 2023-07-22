<?php

namespace Controllers;
use Constants\Rules;
use CustomExceptions\ResourceNotFound;
use Helpers\RequestHelper;
use Models\Post;
use Models\User;

class PostController extends BaseController
{
    protected $validationSchema =[
        "index"=>[
            "url"=>[
                "userId"=>[Rules::INTEGER]
                ]
        ],
        "create"=>[
            "url"=>[
                "userId"=>[Rules::INTEGER]
            ],
            "payload"=>[
                "content"=>[Rules::STRING,Rules::REQUIRED]
            ]
        ],
        "update"=>[
            "url"=>[
                "postId"=>[Rules::INTEGER],
        ],
            "payload"=>[
                "content"=>[Rules::STRING,Rules::REQUIRED]
            ]
            ]
    ];

    protected function index($userId){

        $limit=key_exists("limit",$_GET) ? $_GET["limit"] : 10 ;

        $current_page=key_exists("page",$_GET) ? $_GET["page"] : 1;
        $paginator = Post::query()->
        where("user_id",$userId)->paginate($limit,["id","content","created"],'page',$current_page)
        ->items();

        return $paginator;


    }
    protected function show($postId){
        $post = Post::query()->find($postId);
        if (!$post){
            throw new ResourceNotFound();
        }
        return $post->where("id",$postId)->select("id","content")->get();
    }
protected function create($userId){
        $user = User::query()->find($userId);

    if(!$user){
            throw new ResourceNotFound();
        }
        $payload = RequestHelper::getRequestPayload();

        $post = $user->posts()->create([
            "content"=>$payload["content"]
        ]);

        return ["message"=>"post has been created successfully within id = . $post->id "];

    }
    protected function update($postId){

        $post = Post::query()->find($postId);

        if (!$post){
            throw new ResourceNotFound();
        }
        $payload = RequestHelper::getRequestPayload();
        $post->update([
            "content"=>$payload["content"]]);
        return ["message"=>"post within id #$post->id has been updated successfully"];


    }

    protected function delete($postId){
        $post = Post::query()->find($postId);

        if (!$post){
            throw new ResourceNotFound();
        }
        $post->delete();
        return ["message"=>"post  has been deleted successfully"];
    }
}
