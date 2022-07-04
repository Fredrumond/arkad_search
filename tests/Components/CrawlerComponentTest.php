<?php


use Fredrumond\ArkadCrawler\Adapter\Crawler\DomCrawlerAdapter;
use Fredrumond\ArkadCrawler\Components\CrawlerComponent;
use PHPUnit\Framework\TestCase;

class CrawlerComponentTest extends TestCase
{
    public function testValidConstruct()
    {
        $crawler = new CrawlerComponent(new DomCrawlerAdapter());
        $this->assertInstanceOf(CrawlerComponent::class,$crawler);
    }
}