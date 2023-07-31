<?php

namespace Models;

class Post extends BaseModel
{

    public function user() {

        return $this->belongsTo(User::class);
    }

    public function likes() {

        return $this->hasMany(Like::class);
    }

    public function comments() {

        return $this->hasMany(Comment::class);
    }
}