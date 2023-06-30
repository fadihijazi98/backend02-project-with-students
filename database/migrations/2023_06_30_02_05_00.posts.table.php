<?php
use Illuminate\Database\Capsule\Manager;
use Illuminate\Database\Schema\Blueprint;

Manager::schema()->create("posts",function (Blueprint $table){

    $table->id();
    $table->text("content");
    $table->foreignId("users_id")
    ->constrained()
    ->cascadeOnDelete();
    $table->timestamp("created")->useCurrent();

});
