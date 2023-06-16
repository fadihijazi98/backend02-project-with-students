<?php

namespace Controllers;

class UserController extends BaseController
{
   protected function index(): string
   {
       return "The list of users with their data is now within your reach dear user :)";
   }
    protected function show($userId): string
    {
        return "User's details whose id = $userId is now within your reach dear user :)";
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
