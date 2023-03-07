<?php

namespace Fredrumond\ArkadCrawler\Service;

use Exception;
use Fredrumond\ArkadCrawler\Adapter\Crawler\DomCrawlerAdapter;
use Fredrumond\ArkadCrawler\Adapter\Http\GuzzleHttpAdapter;
use Fredrumond\ArkadCrawler\Components\ConfigComponent;
use Fredrumond\ArkadCrawler\Components\CrawlerComponent;
use Fredrumond\ArkadCrawler\Components\HttpComponent;
use Fredrumond\ArkadCrawler\Domain\DataSource\DataSourceFactory;

class ArkadCrawlerService
{
    private $codes;
    private $settings;

    public function __construct(array $config)
    {
        if (empty($config['dataSource'])) {
            throw new Exception("Cannot start without dataSource");
        }

        $dataSourceFactory = new DataSourceFactory();
        $configComponent = new ConfigComponent($dataSourceFactory);
        $this->settings = $configComponent->chooseDataSource($config);

        if ($this->isValidArguments($config)) {
            $this->codes = $this->settings->extractCodes();
            $this->httpClient = new HttpComponent(new GuzzleHttpAdapter());
        }
    }

    public function search(): array
    {
        $acoes = [];
        $fundos = [];

        if (isset($this->codes[$this->settings::KEY_ACAO])) {
            $acoes = $this->searchByCode($this->codes[$this->settings::KEY_ACAO], $this->settings::KEY_ACAO);
        }

        if (isset($this->codes[$this->settings::KEY_FUNDOS])) {
            $fundos = $this->searchByCode($this->codes[$this->settings::KEY_FUNDOS], $this->settings::KEY_FUNDOS);
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
        $dataSource = $this->settings->component($active);
        $response = $this->httpClient->get('GET', $this->settings->extractUrl($type) . $code);
        $crawler->addContent($response->getBody());
        $crawler->filter($dataSource, $type, $code);

        return $active->infos();
    }

    private function isValidArguments($config): bool
    {
        if (empty($config)) {
            throw new Exception("Cannot start without parameters");
        }

        if (!isset($config[$this->settings::KEY_CODES])) {
            throw new \InvalidArgumentException("Code node not found");
        }

        if (
            isset($config[$this->settings::KEY_CODES][$this->settings::KEY_ACAO]) &&
            empty($config[$this->settings::KEY_CODES][$this->settings::KEY_ACAO])
        ) {
            throw new \InvalidArgumentException("Acoes node cannot be empty");
        }

        if (
            isset($config[$this->settings::KEY_CODES][$this->settings::KEY_FUNDOS]) &&
            empty($config[$this->settings::KEY_CODES][$this->settings::KEY_FUNDOS])
        ) {
            throw new \InvalidArgumentException("Fundos node cannot be empty");
        }

        return true;
    }
}
