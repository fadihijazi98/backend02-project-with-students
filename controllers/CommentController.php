<?php

namespace Controllers;

class CommentController extends BaseController
{
    public function index(): string
    {
        return "The list of comments is now within your reach dear user :)";
    }
    public function show($postId): string
    {
        return "The list of comments of $postId post is now within your reach dear user :)";
    }
    public function create($postId): string
    {
        return "A new comment is written in $postId post dear user :)";
    }
    public function update($postId,$commentId): string
    {
        return "The $commentId comment in $postId post is updated dear user :)";
    }
    public function delete($postId,$commentId): string
    {
        return "The $commentId comment in $postId post is deleted dear user :)";
    }

}
