<?php

namespace Fredrumond\ArkadCrawler\Components;

use Fredrumond\ArkadCrawler\Domain\Active\ActiveAcao;
use Fredrumond\ArkadCrawler\Domain\Active\ActiveFundo;

class ConfigComponent
{
    private const URL_BASE = 'https://statusinvest.com.br/';
    private const ACAO = 'acoes/';
    private const FUNDO = 'fundos-imobiliarios/';

    private $config;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    public function extract()
    {
        return [
            "type" => $this->config['type'],
            "url" => $this->extractUrl(),
            "active" => $this->extractActive(),
            "codes" => $this->config['codes']
        ];
    }

    private function extractAction(): string
    {
        return $this->config['type'] === 'acoes' ? self::ACAO : self::FUNDO;
    }

    private function extractUrl(): string
    {
        return self::URL_BASE . $this->extractAction();
    }

    private function extractActive()
    {
        return $this->config['type'] === 'acoes' ? new ActiveAcao() : new ActiveFundo();
    }
}