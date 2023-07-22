<?php

namespace Models;

use Illuminate\Database\Eloquent\Model;
class User extends Model
{
    protected $guarded = ["id"];
    protected $hidden = ["password"];
    public $timestamps = false;

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

}