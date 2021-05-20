<?php

namespace App;

use App\Core\Framework;

require "Autoload.php";
Autoload::register();

$app = new Framework();
$app->run();





