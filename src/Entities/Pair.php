<?php

namespace Hydra\Exchange\Entities;

class Pair {
    private $currency1;
    private $currency2;

    public function __construct(Currency $currency1, Currency $currency2)
    {
        $this->currency1 = $currency1;
        $this->currency2 = $currency2;
    }

    public function getCurrency1() : Currency
    {
        return $this->currency1;
    }

    public function getCurrency2() : Currency
    {
        return $this->currency2;
    }
}