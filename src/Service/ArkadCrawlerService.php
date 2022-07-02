<?php

namespace Fredrumond\ArkadCrawler\Service;

use Exception;
use Fredrumond\ArkadCrawler\Adapter\Crawler\DomCrawlerAdapter;
use Fredrumond\ArkadCrawler\Adapter\Http\GuzzleHttpAdapter;
use Fredrumond\ArkadCrawler\Components\ConfigComponent;
use Fredrumond\ArkadCrawler\Components\CrawlerComponent;
use Fredrumond\ArkadCrawler\Components\HttpComponent;
use Fredrumond\ArkadCrawler\Components\StatusInvestComponent;
use http\Exception\InvalidArgumentException;

class ArkadCrawlerService
{
    private $codes;
    private $settings;

    public function __construct(array $config)
    {
        if(empty($config)){
            throw new Exception("Cannot start without parameters");
        }

        if(!isset($config['codes'])){
            throw new \InvalidArgumentException("Code node not found");
        }

        if (!array_key_exists("acoes",$config['codes']) || !array_key_exists("fundos",$config['codes'])){
            throw new \InvalidArgumentException("Code needs a fundos and/or ações node");
        }

        $this->settings = new ConfigComponent($config);
        $this->codes = $this->settings->extractCodes();
        $this->httpClient = new HttpComponent(new GuzzleHttpAdapter());
    }

    public function search(): array
    {
        $infos = [];
        foreach ($this->codes['acoes'] as $code) {
            $infos[] = $this->process('acoes', $code);
        }

        foreach ($this->codes['fundos'] as $code) {
            $infos[] = $this->process('fundos', $code);
        }

        return $infos;
    }

    private function process($type, $code)
    {
        $active = $this->settings->extractActive($type);
        $crawler = new CrawlerComponent(new DomCrawlerAdapter());
        $dataSource = new StatusInvestComponent($active);
        $response = $this->httpClient->get('GET', $this->settings->extractUrl($type) . $code);
        $crawler->addContent($response->getBody());
        $crawler->filter($dataSource, $type);

        return $active->infos();
    }
}
