<?php

namespace Hydra\Exchange\Entities;

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
        return $this->primaryBalance;
    }

    public function getSecondary() : int
    {
        return $this->secondaryBalance;
    }

    public function outcomePromary(int $quantity) : self
    {
        $this->buyBalance = $this->buyBalance-$quantity;

        return $this;
    }

    public function outcomeSecondary(int $quantity) : self
    {
        $this->sellBalance = $this->sellBalance-$quantity;

        return $this;
    }

    public function incomePrimary(int $quantity) : self
    {
        $this->buyBalance = $this->buyBalance+$quantity;

        return $this;
    }

    public function incomeSecondary(int $quantity) : self
    {
        $this->sellBalance = $this->sellBalance+$quantity;

        return $this;
    }
}