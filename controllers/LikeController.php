<?php

namespace Controllers;

use Controllers\BaseController;

class LikeController extends BaseController
{
    public function index()
    {
        return "index";
    }
    public function show($post_id)
    {
        return "show";
    }
    public function create($post_id)
    {
        return "create";
    }
    public function update($post_id,$like_id)
    {
        return "update";
    }
    public function delete($post_id,$like_id)
    {
        return "delete";
    }

}