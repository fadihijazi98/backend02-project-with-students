<?php

namespace Controller;

class UserController extends BaseController
{
    /*
        * [GET/user] index()-> get the list of resources
        * [GET/user/{id}]  git resource by id
        *[POST/user] create mew resource
        *[PUT/user/{id}] update resource by id
     * [DELETE/user/{id}] delete resource by id
        * */

protected static function index($userId=00,$postId=00){
return "hello from user Controller  , user #".$userId." post  #".$postId;
}
protected static function show($id){
return " user data for #$id";
}
protected static function create(){
    return " create new user";
}
protected static function update($id){
return "user #$id update successfully";
}
protected static function delete($id){
return "user #$id delete successfully";
}

protected static function like($id){
        return " user  #$id"." liked saleh post ";
}

}