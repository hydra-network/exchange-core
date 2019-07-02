<?php

namespace Hydra\Exchange\Entities;

use \Hydra\Exchange\Interfaces\Entities\Balance as iBalance;
use \Hydra\Exchange\Interfaces\Entities\Pair as iPair;
use \Hydra\Exchange\Exceptions\Balance as BalanceException;

class BuyOrder extends Abstracts\Order
{
    public function __construct(iPair $pair, int $quantity, float $price, iBalance $balance, int $order = null)
    {
        if ($balance->getPrimary() < $quantity*$price) {
            throw new BalanceException("insufficient funds (buy order: " . $balance->getPrimary() . " < " . ($quantity*$price) . ")");
        }

        return parent::__construct($pair, $quantity, $price, $balance, $order, Abstracts\Order::TYPE_BUY);
    }
}