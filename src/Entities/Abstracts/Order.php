<?php

namespace Hydraex\Exchange\Entities\Abstracts;

abstract class Order implements \Hydraex\Exchange\Interfaces\Entities\Order
{
    private $quantity;
    private $quantity_remain;
    private $price;
    private $date;
    private $balance;
    private $pair;
    private $type;

    const TYPE_BUY = 1;
    const TYPE_SELL = 2;

    public function __construct(Pair $pair, int $quantity, int $price, Balance $balance, int $date = null, int $type)
    {
        $this->pair = $pair;
        $this->quantity = $quantity;
        $this->quantity_remain = $quantity;
        $this->price = $price;
        $this->trader = $balance;
        $this->date = $date;
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

    public function getDate() : int
    {
        return $this->date;
    }

    public function getBalance() : Balance
    {
        return $this->trader;
    }

    public function getPair() : Pair
    {
        return $this->pair;
    }

    public function removeQuantity() : self
    {
        $this->quantity_remain = 0;

        return $this;
    }

    public function minusQuantity($amount) : int
    {
        $this->quantity_remain = $this->quantity_remain-$amount;

        return $this;
    }

    public function plusQuantity($amount) : int
    {
        $this->quantity_remain = $this->quantity_remain+$amount;

        return $this;
    }
}