<?php

use Illuminate\Database\Capsule\Manager;
use Illuminate\Database\Schema\Blueprint;

Manager::schema()->create("friends", function (Blueprint $table) {

    $table->id();

    $table->foreignId("users_id")
        ->constrained()
        ->cascadeOnDelete();
    $table->foreignId("friends_id")
        ->constrained("users")
        ->cascadeOnDelete();

    $table->timestamp("created")->useCurrent();
});