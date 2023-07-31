<?php

namespace Models;

class Like extends BaseModel
{

    public function user() {

        return $this->belongsTo(User::class);
    }
}