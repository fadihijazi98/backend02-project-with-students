<?php

namespace Controllers;

class userController extends BaseController
{
    protected function index($userId, $postId) {

        return "user ID : $userId , post ID : $postId";
    }

    protected function show($id) {

        return "user details for #$id.";
    }

    protected function create() {
        return "user has been successfully created.";
    }

    protected function update($id) {
        return "user #$id has been successfully updated.";
    }

    protected function delete($id) {
        return "user #$id has been successfully deleted .";
    }
}