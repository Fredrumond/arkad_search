<?php

use Fredrumond\ArkadCrawler\Components\ConfigComponent;
use PHPUnit\Framework\TestCase;

class ConfigComponentTest extends TestCase
{
    public function testValidConstruct()
    {
        $config = [
            "codes" => [
                "fundos" => [
                    "hsml11"
                ]
            ]
        ];
        $config = new ConfigComponent($config);
        $this->assertInstanceOf(ConfigComponent::class,$config);
    }

}