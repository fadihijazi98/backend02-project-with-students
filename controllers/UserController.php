<?php

namespace Controllers;

use Helpers\RequestHelper;

class UserController extends BaseController{
    protected function index($user_id, $post_id){
        return ["id"=>$user_id,
                "post_id"=>$post_id];
    }
    protected function show($id){
        return ["id"=>$id];
    }
    protected function create(){
        $user_name=RequestHelper::getRequestPayload();

        return "new user '".$user_name['username']."' has created";
    }
    protected function update($id){
        return "user with the #$id has updated successfuly";
    }
    protected function delete($id){
        return "user with the #$id has deleted successfuly";
    }
     protected function like($user_id, $post_id){
        return "user: #$user_id likes post: #$post_id";
    }
}