<?php

namespace Fredrumond\ArkadCrawler\Domain\DataSource;

use Fredrumond\ArkadCrawler\Domain\Active\ActiveInterface;

interface DataSourceInterface
{
    public function extractCodes(): array;
    public function extractUrl(string $type): string;
    public function extractActive(string $type): ActiveInterface;
    public function extractAction(string $type): string;

    public function component(ActiveInterface $active);
}
