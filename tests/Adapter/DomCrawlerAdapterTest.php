<?php

use Fredrumond\ArkadCrawler\Adapter\Crawler\DomCrawlerAdapter;
use PHPUnit\Framework\TestCase;

class DomCrawlerAdapterTest extends TestCase
{
    public function testValidConstruct()
    {
        $crawler = new DomCrawlerAdapter();
        $this->assertInstanceOf(DomCrawlerAdapter::class,$crawler);
    }
}