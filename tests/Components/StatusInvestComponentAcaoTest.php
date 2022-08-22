<?php

use Fredrumond\ArkadCrawler\Components\StatusInvestComponent;
use Fredrumond\ArkadCrawler\Domain\Active\ActiveAcao;
use Fredrumond\ArkadCrawler\Domain\Active\ActiveFundo;
use PHPUnit\Framework\TestCase;

class StatusInvestComponentAcaoTest extends TestCase
{
    public function createActive($element)
    {
        $active = new ActiveAcao();
        $statusInvestComponent = new StatusInvestComponent($active);
        $statusInvestComponent->setElement($element);

        return [
            $statusInvestComponent,
            $active
        ];
    }

    public function testValidConstructAcao()
    {
        $statusInvestComponent = new StatusInvestComponent(new ActiveAcao());
        $this->assertInstanceOf(StatusInvestComponent::class,$statusInvestComponent);
    }

    public function testName()
    {
        $create = $this->createActive('ITUB3 - BANCO ITAU UNIBANCOHOMEAçõesITUB3account_balance_walletbookmarkbookmark_border CompararCompare rentabilidadeCompare Ações');
        $create[0]->setActiveName();
        $result = $create[1]->infos();
        $this->assertEquals('BANCO ITAU UNIBANCO',$result->infos['name']);
    }

    public function testCode()
    {
        $create = $this->createActive('ITUB3 - BANCO ITAU UNIBANCOHOMEAçõesITUB3account_balance_walletbookmarkbookmark_border CompararCompare rentabilidadeCompare Ações');
        $create[0]->setActiveName();
        $result = $create[1]->infos();
        $this->assertEquals('ITUB3',$result->infos['code']);
    }

    public function testCurrentPriceDownward()
    {
        $create = $this->createActive('Valor atualR$19,44arrow_downward-0,66%');
        $create[0]->currentPrice();
        $result = $create[1]->infos();

        $this->assertEquals('19,44',$result->current['price']);
        $this->assertEquals('-0,66%',$result->current['variation']);
    }

    public function testCurrentPriceUpward()
    {
        $create = $this->createActive('Valor atualR$19,44arrow_upward0,66%');
        $create[0]->currentPrice();
        $result = $create[1]->infos();

        $this->assertEquals('19,44',$result->current['price']);
        $this->assertEquals('0,66%',$result->current['variation']);
    }

    public function testMinPrice()
    {
        $create = $this->createActive('Min. 52 semanasR$18,85Min. mêsR$ 19,44');
        $create[0]->minPrice();
        $result = $create[1]->infos();

        $this->assertEquals('18,85',$result->price['lastWeeks']['min']);
        $this->assertEquals('19,44',$result->price['month']['min']);
    }

    public function testMaxPrice()
    {
        $create = $this->createActive('Máx. 52 semanasR$23,84Máx. mêsR$ 19,57');
        $create[0]->maxPrice();
        $result = $create[1]->infos();

        $this->assertEquals('23,84',$result->price['lastWeeks']['max']);
        $this->assertEquals('19,57',$result->price['month']['max']);
    }

    public function testDividendYield()
    {
        $create = $this->createActive('Dividend Yieldhelp_outlineIndicador utilizado para relacionar os proventos pagos por uma companhia e o preço atual de suas ações.Observação:O Dividend Yield foi calculado com base no valor bruto dos proventos com a DATA COM entre 04/07/2021 e 04/07/2022. Amortizações não são consideradas no cálculo.3,01%Últimos 12 mesesR$ 0,5859');
        $create[0]->dividendYield();
        $result = $create[1]->infos();

        $this->assertEquals('3,01',$result->dividendYield['percent']);
        $this->assertEquals('0,5859',$result->dividendYield['value']);
    }

    public function testAppreciation(): void
    {
        $create = $this->createActive('Valorização (12m)arrow_downward-7,21%Mês atualarrow_downward-0,66%');
        $create[0]->appreciation();
        $result = $create[1]->infos();

        $this->assertEquals('-7,21',$result->variation['last12Months']);
        $this->assertEquals('-0,66',$result->variation['currentMonths']);
    }
}