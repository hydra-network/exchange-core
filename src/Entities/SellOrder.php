<?php

namespace Hydra\Exchange\Entities;

use \Hydra\Exchange\Interfaces\Entities\Balance as iBalance;
use \Hydra\Exchange\Interfaces\Entities\Pair as iPair;

class SellOrder extends Abstracts\Order
{
    public function __construct(iPair $pair, int $quantity, int $price, iBalance $balance, int $date = null)
    {
        return parent::__construct($pair, $quantity, $price, $balance, $date, Abstracts\Order::TYPE_SELL);
    }
}