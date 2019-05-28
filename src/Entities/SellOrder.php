<?php

namespace Hydra\Exchange\Entities;

use \Hydra\Exchange\Interfaces\Entities\Balance as iBalance;
use \Hydra\Exchange\Interfaces\Entities\Pair as iPair;
use \Hydra\Exchange\Exceptions\Balance as BalanceException;

class SellOrder extends Abstracts\Order
{
    public function __construct(iPair $pair, int $quantity, int $price, iBalance $balance, int $order = null)
    {
        if ($balance->getSecondary() < $quantity) {
            throw new BalanceException("insufficient funds (sell order)");
        }

        return parent::__construct($pair, $quantity, $price, $balance, $order, Abstracts\Order::TYPE_SELL);
    }
}