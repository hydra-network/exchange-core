<?php

namespace Hydra\Exchange\Entities;

use \Hydra\Exchange\Interfaces\Entities\Balance as iBalance;

class Balance implements \Hydra\Exchange\Interfaces\Entities\Balance
{
    private $primary = 0;
    private $secondary = 0;

    public function __construct($primary, $secondary)
    {
        $this->primary = $primary;
        $this->secondary = $secondary;
    }

    public function getPrimary() : int
    {
        return $this->primary;
    }

    public function getSecondary() : int
    {
        return $this->secondary;
    }

    public function outcomePrimary(int $quantity) : iBalance
    {
        $this->primary = $this->primary-$quantity;

        return $this;
    }

    public function outcomeSecondary(int $quantity) : iBalance
    {
        $this->secondary = $this->secondary-$quantity;

        return $this;
    }

    public function incomePrimary(int $quantity) : iBalance
    {
        $this->primary = $this->primary+$quantity;

        return $this;
    }

    public function incomeSecondary(int $quantity) : iBalance
    {
        $this->secondary = $this->secondary+$quantity;

        return $this;
    }
}