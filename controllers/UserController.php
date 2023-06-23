<?php

namespace Controllers;

class UserController extends BaseController
{
   protected function index(): array
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
    protected function show($userId): array
    {
        return [
            "data"=>
            [
                "id"=>$userId,
                "username"=>"Jamila"
            ]
        ];

    }
    public function create(): string
    {
        return "New user was successfully been added :)";
    }
    public function update($userId): string
    {
        return "User's data whose id = $userId was successfully been updated :)";
    }
    public function delete($userId): string
    {
        return "User's data whose id = $userId was successfully been deleted :)";
    }
}
