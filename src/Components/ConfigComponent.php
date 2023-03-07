<?php

namespace Fredrumond\ArkadCrawler\Components;

use Fredrumond\ArkadCrawler\Domain\DataSource\DataSourceFactoryInterface;
class ConfigComponent
{
    private $dataSourceFactory;

    public function __construct(DataSourceFactoryInterface $dataSourceFactory)
    {
        $this->dataSourceFactory = $dataSourceFactory;
    }

    public function chooseDataSource(array $config)
    {
        return $this->dataSourceFactory->createDataSource($config);
    }
}
