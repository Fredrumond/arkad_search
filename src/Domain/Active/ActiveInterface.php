<?php

namespace Fredrumond\ArkadCrawler\Domain\Active;

interface ActiveInterface
{
    public function name($name);

    public function code($code);

    public function price($price);

    public function variation($variation);

    public function minPriceLastWeekends($minPriceLastWeekends);

    public function minPriceMonth($minPriceMonth);

    public function maxPriceLastWeekends($maxPriceLastWeekends);

    public function maxPriceMonth($maxPriceMonth);

    public function dividendYieldValue($dividendYieldValue);

    public function dividendYieldPercent($dividendYieldPercent);

    public function appreciationLast12Months($appreciationLast12Months);

    public function appreciationCurrentMonths($appreciationCurrentMonths);

    public function infos(): object;
}
