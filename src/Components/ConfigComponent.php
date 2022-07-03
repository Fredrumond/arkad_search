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
    public const KEY_ACAO = 'acoes';
    public const KEY_FUNDOS = 'fundos';
    public const KEY_CODES = 'codes';

    private $config;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    public function extractCodes(): array
    {
        return $this->config[self::KEY_CODES];
    }

    public function extractUrl($type): string
    {
        return self::URL_BASE . $this->extractAction($type);
    }

    public function extractActive($type): ActiveInterface
    {
        return $type === self::KEY_ACAO ? new ActiveAcao() : new ActiveFundo();
    }

    private function extractAction($type): string
    {
        return $type === self::KEY_ACAO ? self::ACAO : self::FUNDO;
    }
}
