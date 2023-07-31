<?php

namespace Models;

class Comment extends BaseModel
{

    public function user() {

        return $this->belongsTo(User::class);
    }
}