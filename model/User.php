<?php

namespace Models;

use Controllers\PostController;
class User extends BaseModel
{
    protected $hidden = ["password"];

    public function posts(){
        return $this->hasMany(Post::class);
    }
}