<?php

use Fredrumond\ArkadCrawler\Service\ArkadCrawlerService;
use PHPUnit\Framework\TestCase;

class ArkadCrawlerServiceTest extends TestCase
{
    public function testInitServiceWithoutConfigParams()
    {
        $this->expectException("Exception");
        $this->expectExceptionMessage("Cannot start without parameters");

        $config = [];
        $service = new ArkadCrawlerService($config);
    }

    public function testInitServiceInvalidParams()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("Code node not found");
        $config = [
            "teste" =>[]
        ];
        $service = new ArkadCrawlerService($config);
    }

    public function testInitServiceInvalidCodeNodes()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("Code needs a fundos and/or ações node");
        $config = [
            "codes" =>[]
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
            ]
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
            ]
        ];
        $service = new ArkadCrawlerService($config);
    }
}