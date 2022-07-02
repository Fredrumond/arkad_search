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
}