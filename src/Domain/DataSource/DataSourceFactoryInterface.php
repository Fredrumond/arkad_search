<?php

namespace Fredrumond\ArkadCrawler\Domain\DataSource;

interface DataSourceFactoryInterface
{
    public function createDataSource(array $config): DataSourceInterface;
}
