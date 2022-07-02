<?php

namespace Fredrumond\ArkadCrawler\Service;

use Exception;
use Fredrumond\ArkadCrawler\Adapter\Crawler\DomCrawlerAdapter;
use Fredrumond\ArkadCrawler\Adapter\Http\GuzzleHttpAdapter;
use Fredrumond\ArkadCrawler\Components\ConfigComponent;
use Fredrumond\ArkadCrawler\Components\CrawlerComponent;
use Fredrumond\ArkadCrawler\Components\HttpComponent;
use Fredrumond\ArkadCrawler\Components\StatusInvestComponent;

class ArkadCrawlerService
{
    private $codes;
    private $settings;

    public function __construct(array $config)
    {
        if(empty($config)){
            throw new Exception("Cannot start without parameters");
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
