<?php

namespace Fredrumond\ArkadCrawler\Service;

use Fredrumond\ArkadCrawler\Adapter\Crawler\DomCrawlerAdapter;
use Fredrumond\ArkadCrawler\Adapter\Http\GuzzleHttpAdapter;
use Fredrumond\ArkadCrawler\Components\CrawlerComponent;
use Fredrumond\ArkadCrawler\Components\HttpComponent;
use Fredrumond\ArkadCrawler\Components\StatusInvestComponent;
use Fredrumond\ArkadCrawler\Domain\Active\ActiveAcao;
use Fredrumond\ArkadCrawler\Domain\Active\ActiveFundo;

class ArkadCrawlerService
{
    CONST URL_BASE = 'https://statusinvest.com.br/';
    CONST ACAO = 'acoes/';
    CONST FUNDO = 'fundos-imobiliarios/';

    private $url;
    private $type;
    private $action;
    private $active;

    public function __construct(Array $config)
    {
        $this->type = $config['type'];
        $this->action = $config['type'] === 'acoes' ? self::ACAO : self::FUNDO;
        $this->url = self::URL_BASE . $this->action . $config['code'];
        $this->active = $config['type'] === 'acoes' ? new ActiveAcao() : new ActiveFundo();

        $this->httpClient = new HttpComponent(new GuzzleHttpAdapter());
        $this->dataSource = new StatusInvestComponent($this->active);
        $this->crawler = new CrawlerComponent(new DomCrawlerAdapter());
    }

    public function search()
    {
        $response = $this->httpClient->get('GET',$this->url);
        $this->crawler->addContent($response->getBody());
        $this->crawler->filter($this->dataSource,$this->type);

        return $this->active->infos();
    }
}