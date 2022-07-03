<?php

use Fredrumond\ArkadCrawler\Components\ConfigComponent;
use PHPUnit\Framework\TestCase;

class ConfigComponentTest extends TestCase
{
    public function createTemplateConfigComponent()
    {
        $config = [
            "codes" => [
                "acoes" => [
                    "itub3"
                ],
                "fundos" => [
                    "hsml11"
                ]
            ]
        ];
        return new ConfigComponent($config);
    }

    public function testValidConstruct()
    {
        $config = $this->createTemplateConfigComponent();
        $this->assertInstanceOf(ConfigComponent::class,$config);
    }

    public function testExtractCode()
    {
        $config = $this->createTemplateConfigComponent();
        $extract = $config->extractCodes();
        $this->assertCount(2,$extract);
    }

}