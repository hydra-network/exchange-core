<?php

namespace Hydra\Exchange\Entities\Abstracts;

use \Hydra\Exchange\Interfaces\Entities\Balance as iBalance;
use \Hydra\Exchange\Libs\Logger;

class Balance implements \Hydra\Exchange\Interfaces\Entities\Balance
{
    private $primary = 0;
    private $secondary = 0;
    private $ownerType;

    const OWNER_BUYER_TAKERER = "buyer";
    const OWNER_TYPE_SELLER = "seller";

    public function __construct(float $primary, float $secondary, $ownerType)
    {
        $this->primary = $primary;
        $this->secondary = $secondary;
        $this->ownerType = $ownerType;
    }

    public function getOwnerType() : string
    {
        return $this->ownerType;
    }

    public function getPrimary() : float
    {
        return $this->primary;
    }

    public function getSecondary() : float
    {
        return $this->secondary;
    }

    public function outcomePrimary(float $quantity) : iBalance
    {
        Logger::write("Outcome primary asset from {$this->ownerType}: {$this->primary}-$quantity");

        $this->primary = $this->primary-$quantity;

        return $this;
    }

    public function outcomeSecondary(float $quantity) : iBalance
    {
        Logger::write("Outcome secondary asset from {$this->ownerType}: {$this->secondary}-$quantity");

        $this->secondary = $this->secondary-$quantity;

        return $this;
    }

    public function incomePrimary(float $quantity) : iBalance
    {
        Logger::write("Income primary asset from {$this->ownerType}: {$this->primary}+$quantity");

        $this->primary = $this->primary+$quantity;

        return $this;
    }

    public function incomeSecondary(float $quantity) : iBalance
    {
        Logger::write("Income secondary asset from {$this->ownerType}: {$this->secondary}+$quantity");

        $this->secondary = $this->secondary+$quantity;

        return $this;
    }
}