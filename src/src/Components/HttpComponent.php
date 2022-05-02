<?php

namespace Fredrumond\ArkadCrawler\Components;

use Fredrumond\ArkadCrawler\Adapter\Http\HttpAdapter;

class HttpComponent
{
    private HttpAdapter $http;

    public function __construct(HttpAdapter $http,)
    {
        $this->http = $http;
    }

    public function get(string $method, string $url)
    {
        return $this->http->get($method,$url);
    }
}