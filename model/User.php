<?php

namespace Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{

    protected $hidden =["password"];
    protected $guarded =['id'];
    public $timestamps=false;
}