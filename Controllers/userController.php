<?php

namespace Controllers;
use Helpers\RequestHelper;

class userController extends BaseController
{
    protected function index() {

        return [
            [
            "id" => 11,
             "username" => "donia.ziyad"
                ],
            [
                "id" => 22,
                "username" => "donia.zi22"
            ],

            ];
    }

    protected function show($id) {

        return [
            $id =>33,
            "username"=>"test"
        ];
    }

    protected function create() {
        $data = RequestHelper::getRequestPayload();
        return $data['username']. " user has been successfully created.";
    }

    protected function update($id) {
        return "user #$id has been successfully updated.";
    }

    protected function delete($id) {
        return "user #$id has been successfully deleted .";
    }
    protected function like($user_id,$post_id){
        return " userId = $user_id likes post $post_id";
    }
}