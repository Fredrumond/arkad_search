<?php

namespace Fredrumond\ArkadCrawler\Components;

use Fredrumond\ArkadCrawler\Domain\Active\ActiveAcao;
use Fredrumond\ArkadCrawler\Domain\Active\ActiveFundo;
use Fredrumond\ArkadCrawler\Domain\Active\ActiveInterface;

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

    public function extractCodes(): array
    {
        return $this->config['codes'];
    }

    public function extractUrl($type): string
    {
        return self::URL_BASE . $this->extractAction($type);
    }

    public function extractActive($type): ActiveInterface
    {
        return $type === 'acoes' ? new ActiveAcao() : new ActiveFundo();
    }

    private function extractAction($type): string
    {
        return $type === 'acoes' ? self::ACAO : self::FUNDO;
    }
}
