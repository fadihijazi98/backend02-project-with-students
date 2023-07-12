<?php

use Illuminate\Database\Capsule\Manager;
use Illuminate\Database\Schema\Blueprint;
Manager::schema()->create("users",function (Blueprint $table){

    $table->id();
    $table->string("name",250);
    $table->string("userName",250)->unique();
    $table->string("email",250)->unique();
    $table->string("profile_image",500);
    $table->string("password",500);
    $table->boolean("isAdmin")->default(false);
    $table->timestamp("created")->useCurrent();

});

