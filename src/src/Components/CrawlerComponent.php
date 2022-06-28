<?php

namespace Fredrumond\ArkadCrawler\Components;

use Fredrumond\ArkadCrawler\Adapter\Crawler\CrawlerAdapter;

class CrawlerComponent
{
    private CrawlerAdapter $crawler;

    public function __construct(CrawlerAdapter $crawler)
    {
        $this->crawler = $crawler;
    }

    public function addContent(string $content)
    {
        $this->crawler->addContent($content);
    }

    public function filter($dataSource, $type)
    {
        return $this->crawler->filter($dataSource, $type);
    }
}
