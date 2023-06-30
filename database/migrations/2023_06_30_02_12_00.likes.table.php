<?php
use Illuminate\Database\Capsule\Manager;
use Illuminate\Database\Schema\Blueprint;

Manager::schema()->create("likes",function (Blueprint $table){

    $table->id();

    $table->foreignId("posts_id")
        ->constrained()
        ->cascadeOnDelete();
    $table->foreignId("users_id")
        ->constrained()
        ->cascadeOnDelete();

    $table->timestamp("created")->useCurrent();
});