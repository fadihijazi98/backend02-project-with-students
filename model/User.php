<?php

namespace Models;

use CustomExceptions\UnAuthorizedException;
use Illuminate\Database\Eloquent\Model;

class User extends BaseModel {

    protected $hidden = ["password"];


    public function posts() {

        return $this->hasMany(Post::class);
    }

    /**
     * @param Model $resource
     * @return void
     * @throws UnAuthorizedException
     */
    public function validateIsUserAuthorizedTo($resource, $customField = "") {

        $customField = $customField ?: "user_id";

        if ($this->id != $resource->$customField) {

            throw new UnAuthorizedException();
        }

    }
}