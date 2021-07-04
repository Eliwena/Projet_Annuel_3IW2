<?php

namespace App;

use App\Core\Framework;

session_start();

require "Autoload.php";
require "Configurations/config.php";
Autoload::register();

$app = new Framework();
$app->run();





