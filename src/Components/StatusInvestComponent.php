<?php

namespace Fredrumond\ArkadCrawler\Components;

use Fredrumond\ArkadCrawler\Domain\Active\ActiveInterface;

class StatusInvestComponent
{
    private $element;
    private $active;

    public function __construct(ActiveInterface $active)
    {
        $this->active = $active;
    }

    public function setElement($element)
    {
        $this->element = $element;
    }

    public function currentPrice(): void
    {
        $data = explode("arrow", $this->element);

        if (str_contains($data[1], "_upward")) {
            $this->active->variation(explode("_upward", $data[1])[1]);
        }

        if (str_contains($data[1], "_downward")) {
            $this->active->variation(explode("_downward", $data[1])[1]);
        }

        $this->active->price(explode("R$", $data[0])[1]);
    }

    public function minPrice(): void
    {
        $data = explode("R$", $this->element);
        $this->active->minPriceLastWeekends(explode('Min', $data[1])[0]);
        $this->active->minPriceMonth(str_replace(" ", "", $data[2]));
    }

    public function maxPrice(): void
    {
        $data = explode("R$", $this->element);
        $this->active->maxPriceLastWeekends(explode('Máx', $data[1])[0]);
        $this->active->maxPriceMonth(str_replace(" ", "", $data[2]));
    }

    public function dividendYield(): void
    {
        $data = explode("DATA COM", $this->element)[1];
        $dividendYield = explode(".", str_replace(" ", "", $data))[2];
        $this->active->dividendYieldValue(explode("R$", $dividendYield)[1]);
        $this->active->dividendYieldPercent(explode("%", $dividendYield)[0]);
    }

    public function appreciation(): void
    {
        $data = explode("Mês", str_replace(" ", "", $this->element));

        if (str_contains($data[0], "arrow_downward")) {
            $this->active->appreciationLast12Months(explode("arrow_downward", str_replace("%", "", $data[0]))[1]);
        }

        if (str_contains($data[0], "arrow_upward")) {
            $this->active->appreciationLast12Months(explode("arrow_upward", str_replace("%", "", $data[0]))[1]);
        }

        if (str_contains($data[1], "arrow_downward")) {
            $this->active->appreciationCurrentMonths(explode("arrow_downward", str_replace("%", "", $data[1]))[1]);
        }

        if (str_contains($data[1], "arrow_upward")) {
            $this->active->appreciationCurrentMonths(explode("arrow_upward", str_replace("%", "", $data[1]))[1]);
        }
    }

    public function patrimony(): void
    {
        $data = explode("Patrimônio", $this->element);
        $this->active->patrimonyQuota(explode("R$", $data[0])[1]);
        $this->active->patrimonyTotal(str_replace(" ", "", explode("R$", $data[1])[1]));
    }

    public function pvp(): void
    {
        $data = explode("Valor de mercado", $this->element);
        $this->active->pvp(explode("P/VP", $data[0])[1]);
        $this->active->marketValue(str_replace(" ", "", explode("R$", $data[1])[1]));
    }

    public function cashValue(): void
    {
        $data = explode("Total", $this->element);
        $this->active->cashValuePercent(str_replace("%", "", explode("Valor em caixa", $data[0])[1]));
        $this->active->cashValue(str_replace(" ", "", explode("R$", $data[1])[1]));
    }

    public function quotas(): void
    {
        $data = explode("Nº de Cotas", $this->element);
        $this->active->quotaHolders(explode("Nº de Cotistas", $data[0])[1]);
        $this->active->quotas($data[1]);
    }
}
