<?php

namespace Fredrumond\ArkadCrawler\Components;

use Fredrumond\ArkadCrawler\Domain\Active;


class StatusInvest
{
    private $element;

    private $active;

    function __construct(Active $active) 
    {
       $this->active = $active;
    }

    public function setElement($element){
        $this->element = $element;
    }

    public function currentPrice() : void
    { 
        $data = explode("arrow",$this->element);

        if(str_contains($data[1],"_upward")){
            $this->active->variation(explode("_upward",$data[1])[1]);
        }

        if(str_contains($data[1],"_downward")){
            $this->active->variation(explode("_downward",$data[1])[1]);
        }

        $this->active->price(explode("R$",$data[0])[1]);
    }

    public function minPrice() : void
    {
        $data = explode("R$",$this->element);
        $this->active->minPriceLastWeekends(explode('Min',$data[1])[0]);
        $this->active->minPriceMonth(str_replace(" ","",$data[2]));
    }

    public function maxPrice() : void
    {
        $data = explode("R$",$this->element);
        $this->active->maxPriceLastWeekends(explode('Máx',$data[1])[0]);
        $this->active->maxPriceMonth(str_replace(" ","",$data[2]));
    }

    public function dividendYield() : void
    {
        $data = explode("DATA COM",$this->element)[1];
        $dividendYield = explode(".",str_replace(" ","",$data))[2];
        $this->active->dividendYieldValue(explode("R$",$dividendYield)[1]);
        $this->active->dividendYieldPercent(explode("%",$dividendYield)[0]);

    }

    public function appreciation() : void
    {
        $data = explode("Mês",str_replace(" ","",$this->element));

        if(str_contains($data[0],"arrow_downward")){
            $this->active->appreciationLast12Months(explode("arrow_downward",str_replace("%","",$data[0]))[1]);
        }

        if(str_contains($data[0],"arrow_upward")){
            $this->active->appreciationLast12Months(explode("arrow_upward",str_replace("%","",$data[0]))[1]);
        }

        if(str_contains($data[1],"arrow_downward")){
            $this->active->appreciationCurrentMonths(explode("arrow_downward",str_replace("%","",$data[1]))[1]);
        }

        if(str_contains($data[1],"arrow_upward")){
            $this->active->appreciationCurrentMonths(explode("arrow_upward",str_replace("%","",$data[1]))[1]);
        }
    }

    
}
