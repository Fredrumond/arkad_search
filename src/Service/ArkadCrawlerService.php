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
        if ($this->isValidArguments($config)) {
            $this->settings = new ConfigComponent($config);
            $this->codes = $this->settings->extractCodes();
            $this->httpClient = new HttpComponent(new GuzzleHttpAdapter());
        }
    }

    public function search(): array
    {
        $acoes = [];
        $fundos = [];

        if(isset($this->codes[ConfigComponent::KEY_ACAO])){
            $acoes = $this->searchByCode($this->codes[ConfigComponent::KEY_ACAO], ConfigComponent::KEY_ACAO);
        }

        if(isset($this->codes[ConfigComponent::KEY_FUNDOS])){
            $fundos = $this->searchByCode($this->codes[ConfigComponent::KEY_FUNDOS], ConfigComponent::KEY_FUNDOS);
        }

        return array_merge($acoes, $fundos);
    }

    private function searchByCode($codes, $type): array
    {
        $infos = [];
        foreach ($codes as $code) {
            $infos[] = $this->process($type, $code);
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

    private function isValidArguments($config): bool
    {
        if (empty($config)) {
            throw new Exception("Cannot start without parameters");
        }

        if (!isset($config[ConfigComponent::KEY_CODES])) {
            throw new \InvalidArgumentException("Code node not found");
        }

//        print_r($config);die();
//        if (!array_key_exists(ConfigComponent::KEY_ACAO, $config[ConfigComponent::KEY_CODES]) || !array_key_exists(ConfigComponent::KEY_FUNDOS, $config[ConfigComponent::KEY_CODES])) {
//            throw new \InvalidArgumentException("Code needs a fundos and/or ações node");
//        }

        if (isset($config[ConfigComponent::KEY_CODES][ConfigComponent::KEY_ACAO]) && empty($config[ConfigComponent::KEY_CODES][ConfigComponent::KEY_FUNDOS])) {
            throw new \InvalidArgumentException("Acoes node cannot be empty");
        }

        if (isset($config[ConfigComponent::KEY_CODES][ConfigComponent::KEY_FUNDOS]) && empty($config[ConfigComponent::KEY_CODES][ConfigComponent::KEY_FUNDOS])) {
            throw new \InvalidArgumentException("Fundos node cannot be empty");
        }

        return true;
    }
}
