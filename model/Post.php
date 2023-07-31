<?php

namespace Models;
use Controllers\CommentController;

class Post extends BaseModel
{

    public function user(){
        return $this->belongsTo(User::class);
    }
    public function comments(){
        return $this->hasMany(Comment::class);
    }

    public function likes(){
        return $this->hasMany(Like::class);
    }
}
