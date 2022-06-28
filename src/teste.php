<?php

require __DIR__ . '/vendor/autoload.php';

use Fredrumond\ArkadCrawler\Service\ArkadCrawlerService;

//$config = [
//    "type" => 'fundos',
//    "code" => "hsml11"
//];
//$config = [
//    "type" => 'acoes',
//    "codes" => ["itub3","sapr4"]
//];

$config = [
    "codes" => [
        "acoes" => [
            "itub3","sapr4"
        ],
        "fundos" => [
            "hsml11"
        ]
    ]
];

$service = new ArkadCrawlerService($config);
var_dump($service->search());
