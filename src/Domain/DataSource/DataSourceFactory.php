<?php

namespace Fredrumond\ArkadCrawler\Domain\DataSource;

class DataSourceFactory implements DataSourceFactoryInterface
{
    public function createDataSource(array $config): DataSourceInterface
    {
        switch ($config['dataSource']) {
            case 'statusInvest':
                return new DataSourceStatusInvest($config);
            default:
                throw new InvalidArgumentException(sprintf('Invalid data source type: %s', $config['dataSource']));
        }
    }
}
