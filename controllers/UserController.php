<?php

namespace Controllers;

class UserController extends BaseController
{
   protected function index(): string
   {
       return "The list of users with their data is now within your reach dear user :)";
   }
    protected function show($id): string
    {
        return "User's details whose id = #$id is now within your reach dear user :)";
    }
    public function create(): string
    {
        return "New user was successfully been added :)";
    }
    public function update($id): string
    {
        return "User's data whose id = #$id was successfully been updated :)";
    }
    public function delete($id): string
    {
        return "User's data whose id = #$id was successfully been deleted :)";
    }
}
