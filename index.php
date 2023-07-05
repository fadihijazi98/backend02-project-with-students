<?php


require 'vendor/autoload.php';
use Controller\CommentsController;
use Controller\LikesController;
use component\Route;
require "routes/v1/route.php";
require "routes/v2/route.php";

Route::handelRequest();

