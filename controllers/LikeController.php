<?php

namespace Controllers;

class LikeController extends BaseController
{
    public function index(): string
    {
        return "The list of likes is now within your reach dear user :)";
    }
    public function show($postId): string
    {
        return "The list of likes of post whose id = $postId is now within your reach dear user :)";
    }
    public function create($postId): string
    {
        return "A new like is created in post whose id = $postId dear user :)";
    }
    public function update($postId,$likeId): string
    {
        return "The like whose id = $likeId in post whose id =  $postId is updated dear user :)";
    }
    public function delete($postId,$likeId): string
    {
        return "The like whose id = $likeId in post whose id = $postId is deleted dear user :)";
    }

}