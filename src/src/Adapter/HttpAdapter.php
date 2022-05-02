<?php

namespace Fredrumond\ArkadCrawler\Adapter;

interface HttpAdapter
{
    public function get(string $method, string $url);
}