<?php

namespace Hydra\Exchange\Entities;

class Trader {
    private $currency1Balance = 0;
    private $currency2Balance = 0;

    public function __construct($buyBalance, $sellBalance)
    {
        $this->buyBalance = $buyBalance;
        $this->sellBalance = $sellBalance;
    }

    public function getBuyBalance()
    {
        return $this->buyBalance;
    }

    public function getSellBalance()
    {
        return $this->sellBalance;
    }

    public function newOutcome1($quantity)
    {
        $this->currency1Balance = $this->currency1Balance-$quantity;
    }

    public function newOutcome2($quantity)
    {
        $this->currency2Balance = $this->currency2Balance-$quantity;
    }

    public function newIncome1($quantity)
    {
        $this->currency1Balance = $this->currency1Balance+$quantity;
    }

    public function newIncome2($quantity)
    {
        $this->currency2Balance = $this->currency2Balance+$quantity;
    }
}