<?php

namespace Fredrumond\ArkadCrawler\Service;

use Fredrumond\ArkadCrawler\Components\StatusInvest;
use Fredrumond\ArkadCrawler\Domain\Active\ActiveAcao;
use Fredrumond\ArkadCrawler\Domain\Active\ActiveFundo;
use Symfony\Component\DomCrawler\Crawler;

class ArkadCrawlerService
{
    CONST URL_BASE = 'https://statusinvest.com.br/';
    CONST ACAO = 'acoes/';
    CONST FUNDO = 'fundos-imobiliarios/';

    private $url;
    private $type;

    public function __construct(Array $config)
    {
        $this->type = $config['type'];
        $type = $config['type'] === 'acoes' ? self::ACAO : self::FUNDO;
        $this->url = self::URL_BASE . $type . $config['code'];
    }

    public function search()
    {
        $active = $this->type === 'acoes' ? new ActiveAcao() : new ActiveFundo();
        $statusInvest = new StatusInvest($active);
        $client = new \GuzzleHttp\Client();

        $response = $client->request('GET', $this->url);

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

            if($this->type !== 'acoes'){
                if($key == 5){
                    $patrimony = $statusInvest->patrimony();
                }

                if($key == 6){
                    $pvp = $statusInvest->pvp();
                }

                if($key == 7){
                    $pvp = $statusInvest->cashValue();
                }

                if($key == 10){
                    $quotas = $statusInvest->quotas();
                }
            }


        }

        return $active->infos();
    }
}