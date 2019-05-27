<?php

namespace Hydra\Exchange\Entities;

class BuyOrder extends Abstracts\Order
{
    public function __construct(int $id, Pair $pair, int $quantity, int $price, Balance $balance, int $date = null)
    {
        return parent::__construct($id, $pair, $quantity, $price, $balance, $date, Order::TYPE_BUY);
    }
}