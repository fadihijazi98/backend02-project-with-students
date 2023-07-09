<?php

namespace Controller;

class LikesController
{
    public static function index(){
        return 'like page';

    }
    public static function create($userID){

        return ["message "=>"user #$userID liked on the post "];
    }

}