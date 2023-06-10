<?php

require 'vendor/autoload.php';

use Components\Route;

require 'routes/v1/route.php';
require 'routes/v2/route.php';

Route::handleRequest(); // route concept
