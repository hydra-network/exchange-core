<?php

namespace Hydra\Exchange\Entities\Abstracts;

use \Hydra\Exchange\Interfaces\Entities\Order as iOrder;
use \Hydra\Exchange\Interfaces\Entities\Pair as iPair;
use \Hydra\Exchange\Interfaces\Entities\Balance as iBalance;

abstract class Order implements iOrder
{
    private $quantity;
    private $quantity_remain;
    private $price;
    private $order;
    private $balance;
    private $pair;
    private $type;

    const TYPE_BUY = 1;
    const TYPE_SELL = 2;

    public function __construct(iPair $pair, int $quantity, int $price, iBalance $balance, int $order = null, int $type)
    {
        $this->pair = $pair;
        $this->quantity = $quantity;
        $this->quantity_remain = $quantity;
        $this->price = $price;
        $this->trader = $balance;
        $this->order = $order;
        $this->type = $type;
    }

    public function getType() : int
    {
        return $this->type;
    }

    public function getPrice() : int
    {
        return $this->price;
    }

    public function getQuantity() : int
    {
        return $this->quantity;
    }

    public function getQuantityRemain() : int
    {
        return $this->quantity_remain;
    }

    public function getCost() : int
    {
        return $this->quantity * $this->price;
    }

    public function getCostRemain() : int
    {
        return $this->quantity_remain * $this->price;
    }

    public function getOrderNumber() : int
    {
        return $this->order;
    }

    public function getBalance() : iBalance
    {
        return $this->trader;
    }

    public function getPair() : iPair
    {
        return $this->pair;
    }

    public function removeQuantity() : iOrder
    {
        $this->quantity_remain = 0;

        return $this;
    }

    public function minusQuantity($amount) : iOrder
    {
        $this->quantity_remain = $this->quantity_remain-$amount;

        return $this;
    }

    public function plusQuantity($amount) : iOrder
    {
        $this->quantity_remain = $this->quantity_remain+$amount;

        return $this;
    }
}