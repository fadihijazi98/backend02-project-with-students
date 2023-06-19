<?php

namespace Controllers;

use Helpers\RequestHelper;

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
    public function create($userId): string
    {
        $data = RequestHelper::getRequestPayLoad();
        return "New user with " .$data["username"]." was successfully been added :)";
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
