<?php

namespace Controllers;

class UserController extends BaseController
{
   protected function index(): string
   {
       return [
           "data"=>
           [
               "id"=>"1",
               "username"=>"Jamila"
           ]
           ,
           [
               "id"=>"2",
               "username"=>"Abdullah"
           ]
       ];
   }
    protected function show($userId): string
    {
        return [
            "data"=>
            [
                "id"=>$userId,
                "username"=>"Jamila"
            ]
        ];

    }
    public function create($userId): string
    {
        return "New user was successfully been added :)";
    }
    public function update($userId,$id): string
    {
        return "User's data whose id = $userId was successfully been updated :)";
    }
    public function delete($userId,$id): string
    {
        return "User's data whose id = $userId was successfully been deleted :)";
    }
}
