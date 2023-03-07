<?php

use Fredrumond\ArkadCrawler\Service\ArkadCrawlerService;
use PHPUnit\Framework\TestCase;

class ArkadCrawlerServiceTest extends TestCase
{
    public function testInitServiceWithoutConfigDataSource()
    {
        $this->expectException("Exception");
        $this->expectExceptionMessage("Cannot start without dataSource");

        $config = [];
        $service = new ArkadCrawlerService($config);
    }
    public function testInitServiceInvalidParams()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("Code node not found");
        $config = [
            "teste" =>[],
            "dataSource" => 'statusInvest'
        ];
        $service = new ArkadCrawlerService($config);
    }

    public function testInitServiceEmptyCodesAcoes()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("Acoes node cannot be empty");
        $config = [
            "codes" => [
                "acoes" => []
            ],
            "dataSource" => 'statusInvest'
        ];
        $service = new ArkadCrawlerService($config);
    }

    public function testInitServiceEmptyCodesFundos()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("Fundos node cannot be empty");
        $config = [
            "codes" => [
                "fundos" => []
            ],
            "dataSource" => 'statusInvest'
        ];
        $service = new ArkadCrawlerService($config);
    }

    public function testValidConstruct()
    {
        $config = [
            "codes" => [
                "fundos" => [
                    "hsml11"
                ]
            ],
            "dataSource" => 'statusInvest'
        ];
        $service = new ArkadCrawlerService($config);
        $this->assertInstanceOf(ArkadCrawlerService::class,$service);
    }

    public function testSearchResult()
    {
        $config = [
            "codes" => [
                "acoes" => [
                    "itub3"
                ],
                "fundos" => [
                    "hsml11"
                ]
            ],
            "dataSource" => 'statusInvest'
        ];
        $service = $this->createMock(ArkadCrawlerService::class);
        $service->method('search')->willReturn(
            [
               [],[]
            ]
        );

        $result = $service->search();
        $this->assertCount(2,$result);
    }

}
