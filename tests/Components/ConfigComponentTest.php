<?php

use Fredrumond\ArkadCrawler\Components\ConfigComponent;
use Fredrumond\ArkadCrawler\Domain\DataSource\DataSourceFactory;
use Fredrumond\ArkadCrawler\Domain\DataSource\DataSourceInterface;
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
            ],
            "dataSource" => 'statusInvest'
        ];
        $dataSourceFactory = new DataSourceFactory();
        $configComponent = new ConfigComponent($dataSourceFactory);
        return $configComponent->chooseDataSource($config);
    }

    public function testValidConstruct()
    {
        $config = $this->createTemplateConfigComponent();
        $this->assertInstanceOf(DataSourceInterface::class,$config);
    }

    public function testExtractCode()
    {
        $config = $this->createTemplateConfigComponent();
        $extract = $config->extractCodes();
        $this->assertCount(2,$extract);
    }

    public function testExtractUrlAcoes()
    {
        $config = $this->createTemplateConfigComponent();
        $extractUrl = $config->extractUrl('acoes');
        $this->assertEquals('https://statusinvest.com.br/acoes/',$extractUrl);
    }

    public function testExtractUrlFundos()
    {
        $config = $this->createTemplateConfigComponent();
        $extractUrl = $config->extractUrl('fundos');
        $this->assertEquals('https://statusinvest.com.br/fundos-imobiliarios/',$extractUrl);
    }

}