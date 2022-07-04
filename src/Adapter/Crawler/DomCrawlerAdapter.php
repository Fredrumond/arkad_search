<?php

namespace Fredrumond\ArkadCrawler\Adapter\Crawler;

use Symfony\Component\DomCrawler\Crawler;

class DomCrawlerAdapter implements CrawlerAdapter
{
    private $crawler;
    private $content;

    public function __construct()
    {
        $this->crawler = new Crawler();
    }

    public function addContent(string $content)
    {
        $this->content =  $this->crawler->addHtmlContent($content);
    }

    public function filter($dataSource, $type)
    {
        foreach ($this->crawler->filter('.top-info .info') as $key => $domElement) {
            $domElementSanetize = str_replace("\n", "", $domElement->nodeValue);
            echo $key . "======";
            var_dump($domElementSanetize);
            $dataSource->setElement($domElementSanetize);

            if ($key == 0) {
                $dataSource->currentPrice();
            }

            if ($key == 1) {
                $dataSource->minPrice();
            }

            if ($key == 2) {
                $dataSource->maxPrice();
            }

            if ($key == 3) {
                $dataSource->dividendYield();
            }

            if ($key == 4) {
                $dataSource->appreciation();
            }

            if ($type !== 'acoes') {
                if ($key == 5) {
                    $dataSource->patrimony();
                }

                if ($key == 6) {
                    $dataSource->pvp();
                }

                if ($key == 7) {
                    $dataSource->cashValue();
                }

                if ($key == 10) {
                    $dataSource->quotas();
                }
            }
        }

        return true;
    }
}
