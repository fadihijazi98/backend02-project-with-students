<?php

namespace Models;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $guarded = ["id"];
    public $timestamps = false;
}