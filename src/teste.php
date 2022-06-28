<?php

require __DIR__ . '/vendor/autoload.php';

use Fredrumond\ArkadCrawler\Service\ArkadCrawlerService;

//$config = [
//    "type" => 'fundos',
//    "code" => "hsml11"
//];
$config = [
    "type" => 'acoes',
    "codes" => ["itub3","sapr4"]
];
//$config = [
//    "type" => 'acoes',
//    "codes" => ["itub3"]
//];

$service = new ArkadCrawlerService($config);
var_dump($service->search());
