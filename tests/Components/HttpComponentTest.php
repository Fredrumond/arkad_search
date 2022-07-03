<?php

use Fredrumond\ArkadCrawler\Adapter\Http\GuzzleHttpAdapter;
use Fredrumond\ArkadCrawler\Components\HttpComponent;
use PHPUnit\Framework\TestCase;

class HttpComponentTest extends TestCase
{
    public function testValidConstruct()
    {
        $http = new HttpComponent(new GuzzleHttpAdapter());
        $this->assertInstanceOf(HttpComponent::class,$http);
    }

    public function testGet()
    {
        $httpComponent = $this->createMock(HttpComponent::class);
        $httpComponent->method('get')->willReturn(
            'url_teste'
        );

        $result = $httpComponent->get('GET','url_teste');
        $this->assertEquals('url_teste',$result);
    }
}