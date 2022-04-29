<?php

require __DIR__ . '/vendor/autoload.php';

use Fredrumond\ArkadCrawler\Service\ArkadCrawlerService;

$config = [
    "type" => 'fundos',
    "code" => "hsml11"
];

$service = new ArkadCrawlerService($config);
var_dump($service->search());
