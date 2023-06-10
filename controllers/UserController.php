<?php
namespace Controllers;

class UserController extends BaseController {

    protected function index() {

        return "[user.id:11, user.id:12, user.id:13]";
    }

    protected function show($id) {

        return "[user.id:#$id" .
            ", user.name: fadi]";
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

    protected function like($user_id, $post_id) {
        return "user #$user_id likes post #$post_id";
    }
}