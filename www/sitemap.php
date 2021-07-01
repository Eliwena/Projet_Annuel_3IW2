<?php

$base_url = "http://localhost/";

$lines = file('./Configurations/routes.yml');

$stringOfRoutes = "index";
foreach($lines as $line){
    if(substr($line, 0, 1) === '/'){
        $stringOfRoutes .= trim(str_replace(":", "", $line), "/");
    }
}
$arrayOfRoutes = explode("\n", trim($stringOfRoutes));


header("Content-Type: application/xml; charset=utf-8");

echo '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL;

echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'.PHP_EOL;

for($i = 0; $i < count($arrayOfRoutes); $i++)
{
    echo '<url>' . PHP_EOL;
    echo '<loc>' . $base_url . $arrayOfRoutes[$i] . '</loc>' . PHP_EOL;
    echo '<changefreq>daily</changefreq>' . PHP_EOL;
    echo '</url>' . PHP_EOL;
}

echo '</urlset>' . PHP_EOL;

?>