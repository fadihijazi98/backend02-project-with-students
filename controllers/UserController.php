<?php
namespace Controllers;

class UserController extends BaseController {

    protected function index() {

        return [
            [
                "id" => 10,
                "username" => "saleh.zetawi"
            ],
            [
                "id" => 11,
                "username" => "ibrahim.s99"
            ]
        ];
    }

    protected function show($id) {

        return [
            "id" => $id,
            'username' => 'global.testing'
        ];
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