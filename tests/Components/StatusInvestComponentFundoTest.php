<?php

use Fredrumond\ArkadCrawler\Components\StatusInvestComponent;
use Fredrumond\ArkadCrawler\Domain\Active\ActiveAcao;
use Fredrumond\ArkadCrawler\Domain\Active\ActiveFundo;
use PHPUnit\Framework\TestCase;

class StatusInvestComponentFundoTest extends TestCase
{
    public function createActive($element)
    {
        $active = new ActiveFundo();
        $statusInvestComponent = new StatusInvestComponent($active);
        $statusInvestComponent->setElement($element);

        return [
            $statusInvestComponent,
            $active
        ];
    }

    public function testValidConstructFundo()
    {
        $statusInvestComponent = new StatusInvestComponent(new ActiveFundo());
        $this->assertInstanceOf(StatusInvestComponent::class,$statusInvestComponent);
    }

    public function testName()
    {
        $create = $this->createActive('HSML11 - HSI MALL FDO INV IMOBHOMEFundos ImobiliáriosHSML11account_balance_walletbookmarkbookmark_border CompararCompare rentabilidadeCompare FIIs');
        $create[0]->setActiveName();
        $result = $create[1]->infos();
        $this->assertEquals('HSI MALL FDO INV IMOB',$result->infos['name']);
    }

    public function testCode()
    {
        $create = $this->createActive('HSML11 - HSI MALL FDO INV IMOBHOMEFundos ImobiliáriosHSML11account_balance_walletbookmarkbookmark_border CompararCompare rentabilidadeCompare FIIs');
        $create[0]->setActiveName();
        $result = $create[1]->infos();
        $this->assertEquals('HSML11',$result->infos['code']);
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

    public function testPatrimony(): void
    {
        $create = $this->createActive('Val. patrim. p/cotaValor patrim. p/cotaVal. patrimonial p/cotaR$93,17PatrimônioR$ 1.470.237.699');
        $create[0]->patrimony();
        $result = $create[1]->infos();

        $this->assertEquals('93,17',$result->patrimony['quota']);
        $this->assertEquals('1.470.237.699',$result->patrimony['total']);
    }

    public function testPvp(): void
    {
        $create = $this->createActive('P/VP0,83Valor de mercadoR$ 1.219.052.354');
        $create[0]->pvp();
        $result = $create[1]->infos();

        $this->assertEquals('0,83',$result->pvp);
    }

    public function testMarketValue(): void
    {
        $create = $this->createActive('P/VP0,83Valor de mercadoR$ 1.219.052.354');
        $create[0]->pvp();
        $result = $create[1]->infos();

        $this->assertEquals('1.219.052.354',$result->marketValue);
    }

    public function testCashValue(): void
    {
        $create = $this->createActive(' Valor em caixa4,02%TotalR$ 59.095.105,26');
        $create[0]->cashValue();
        $result = $create[1]->infos();

        $this->assertEquals('59.095.105,26',$result->cash['value']);
        $this->assertEquals('4,02',$result->cash['percent']);
    }

    public function testQuotas(): void
    {
        $create = $this->createActive('Nº de Cotistas121.063 Nº de Cotas15.780.613');
        $create[0]->quotas();
        $result = $create[1]->infos();

        $this->assertEquals('121.063 ',$result->quotas['quotaHolders']);
        $this->assertEquals('15.780.613',$result->quotas['total']);
    }
}