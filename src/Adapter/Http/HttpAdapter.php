<?php

namespace Fredrumond\ArkadCrawler\Adapter\Http;

interface HttpAdapter
{
    public function get(string $method, string $url);
}
