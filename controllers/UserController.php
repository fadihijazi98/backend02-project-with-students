<?php
namespace Controllers;

class UserController extends BaseController {

    protected function index($userId, $postId) {

        return "Hello user #" . $userId . " why you want content of post #" . $postId;
    }

    protected function show($id) {

        return "user details for #$id.";
    }

    protected function create() {
        return "new Saleh user created";
    }

    protected function update($id) {
        return "user #$id updated successfully.";
    }

    protected function delete($id) {
        return "user #$id deleted successfully.";
    }
}