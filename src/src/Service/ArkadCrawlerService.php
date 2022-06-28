<?php

namespace Fredrumond\ArkadCrawler\Service;

use Fredrumond\ArkadCrawler\Adapter\Crawler\DomCrawlerAdapter;
use Fredrumond\ArkadCrawler\Adapter\Http\GuzzleHttpAdapter;
use Fredrumond\ArkadCrawler\Components\ConfigComponent;
use Fredrumond\ArkadCrawler\Components\CrawlerComponent;
use Fredrumond\ArkadCrawler\Components\HttpComponent;
use Fredrumond\ArkadCrawler\Components\StatusInvestComponent;
//use Fredrumond\ArkadCrawler\Domain\Active\ActiveAcao;
//use Fredrumond\ArkadCrawler\Domain\Active\ActiveFundo;

class ArkadCrawlerService
{
//    private const URL_BASE = 'https://statusinvest.com.br/';
//    private const ACAO = 'acoes/';
//    private const FUNDO = 'fundos-imobiliarios/';

    private $url;
    private $type;
    private $active;
    private $codes;

    public function __construct(array $config)
    {
        $settings = new ConfigComponent($config);
        $configInformation = $settings->extract();

        $this->type = $configInformation['type'];
        $this->url = $configInformation['url'];
        $this->active = $configInformation['active'];
        $this->codes = $configInformation['codes'];

        $this->httpClient = new HttpComponent(new GuzzleHttpAdapter());
        $this->dataSource = new StatusInvestComponent($this->active);
    }

    public function search(): array
    {
        $infos = [];
        foreach ($this->codes as $code){
            $crawler = new CrawlerComponent(new DomCrawlerAdapter());
            $response = $this->httpClient->get('GET', $this->url . $code);
            $crawler->addContent($response->getBody());
            $crawler->filter($this->dataSource, $this->type);

            $infos[] = $this->active->infos();
        }

        return $infos;
    }
}
