<?php

namespace App;

use App\Core\Framework;
use App\Core\Autoload;

if(session_status() == PHP_SESSION_DISABLED) { session_start(); }

require "../Core/Autoload.php";
require "../Configurations/config.php";
Autoload::register();

$app = new Framework();
$app->run();





