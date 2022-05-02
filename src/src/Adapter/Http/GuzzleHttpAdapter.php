<?php

namespace Fredrumond\ArkadCrawler\Adapter\Http;

class GuzzleHttpAdapter implements HttpAdapter
{
    private $client;

    public function __construct()
    {
        $this->client = new \GuzzleHttp\Client();
    }

    public function get(string $method, string $url)
    {
        return $this->client->request($method, $url);
    }
}
