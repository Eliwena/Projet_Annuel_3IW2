<?php

namespace App;

use App\Core\Framework;
use App\Core\Autoload;
use App\Core\Helpers;

session_start();

require "../Core/Autoload.php";
require "../Configurations/config.php";
Autoload::register();

$app = new Framework();
$app->run();




