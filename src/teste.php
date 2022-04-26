<?php

require __DIR__ . '/vendor/autoload.php';

use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;
use Fredrumond\ArkadCrawler\Components\StatusInvest;
use Fredrumond\ArkadCrawler\Domain\Active;

$active = new Active();
$statusInvest = new StatusInvest($active);


$client = new \GuzzleHttp\Client();
$response = $client->request('GET', 'https://statusinvest.com.br/fundos-imobiliarios/hsml11');

$crawler = new Crawler();
$crawler->addHtmlContent($response->getBody());

foreach ($crawler->filter('.top-info .info') as $key => $domElement) {

    $domElementSanetize = str_replace("\n","",$domElement->nodeValue);
    $statusInvest->setElement($domElementSanetize);

    if($key == 0){
        $currentPrice = $statusInvest->currentPrice();
    }

    if($key == 1){
        $minPrice = $statusInvest->minPrice();
    }

    if($key == 2){
        $maxPrice = $statusInvest->maxPrice();
    }

    if($key == 3){
        $dividendYield = $statusInvest->dividendYield();
    }

    if($key == 4){
        $appreciation = $statusInvest->appreciation();
    }
}

// var_dump($statusInvest->generateInfos());
var_dump($active->infos());