<?php

namespace Fredrumond\ArkadCrawler\Domain;

class Active
{
    private $name;
    private $price;
    private $variation;
    private $minPriceLastWeekends;
    private $minPriceMonth;
    private $maxPriceLastWeekends;
    private $maxPriceMonth;
    private $dividendYieldValue;
    private $dividendYieldPercent;
    private $appreciationLast12Months;
    private $appreciationCurrentMonths;
    private $patrimonyQuota;
    private $patrimonyTotal;

    public function price($price)
    {
        $this->price = $price;
    }

    public function variation($variation)
    {
        $this->variation = $variation;
    }

    public function minPriceLastWeekends($minPriceLastWeekends)
    {
        $this->minPriceLastWeekends = $minPriceLastWeekends;
    }

    public function minPriceMonth($minPriceMonth)
    {
        $this->minPriceMonth = $minPriceMonth;
    }

    public function maxPriceLastWeekends($maxPriceLastWeekends)
    {
        $this->maxPriceLastWeekends = $maxPriceLastWeekends;
    }

    public function maxPriceMonth($maxPriceMonth)
    {
        $this->maxPriceMonth = $maxPriceMonth;
    }

    public function dividendYieldValue($dividendYieldValue)
    {
        $this->dividendYieldValue = $dividendYieldValue;
    }

    public function dividendYieldPercent($dividendYieldPercent)
    {
        $this->dividendYieldPercent = $dividendYieldPercent;
    }

    public function appreciationLast12Months($appreciationLast12Months)
    {
        $this->appreciationLast12Months = $appreciationLast12Months;
    }

    public function appreciationCurrentMonths($appreciationCurrentMonths)
    {
        $this->appreciationCurrentMonths = $appreciationCurrentMonths;
    }

    public function patrimonyQuota($patrimonyQuota)
    {
        $this->patrimonyQuota = $patrimonyQuota;
    }

    public function patrimonyTotal($patrimonyTotal)
    {
        $this->patrimonyTotal = $patrimonyTotal;
    }

    public function infos(): object
    {
        return (object)[
            "current" => [
                "price" => $this->price,
                "variation" => $this->variation,
            ],
            "price" => [
                "lastWeeks" => [
                    "min" => $this->minPriceLastWeekends,
                    "max" => $this->maxPriceLastWeekends,
                ],
                "month" => [
                    "min" => $this->minPriceMonth,
                    "max" => $this->maxPriceMonth,
                    ]
                ],
            "dividendYield" => [
                "percent" => $this->dividendYieldPercent,
                "value" => $this->dividendYieldValue
            ],
            "variation" => [
                "last12Months" => $this->appreciationLast12Months,
                "currentMonths" => $this->appreciationCurrentMonths,
            ],
            "patrimony" => [
                "quota" => $this->patrimonyQuota,
                "total" => $this->patrimonyTotal
            ]
        ];
    }
}
