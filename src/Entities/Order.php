<?php

namespace Hydra\Exchange\Entities;

class Order {
    private $id;
    private $quantity;
    private $quantity_remain;
    private $price;
    private $date;
    private $trader;
    private $pair;

    public function __construct($id, Pair $pair, $quantity, $price, Trader $trader, $date = null)
    {
        $this->id = $id;
        $this->pair = $pair;
        $this->quantity = $quantity;
        $this->quantity_remain = $quantity;
        $this->price = $price;
        $this->trader = $trader;
        $this->date = $date;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function getQuantity()
    {
        return $this->quantity;
    }

    public function removeQuantity()
    {
        $this->quantity_remain = 0;

        return $this;
    }

    public function minusQuantity($amount)
    {
        $this->quantity_remain = $this->quantity_remain-$amount;

        return $this;
    }

    public function plusQuantity($amount)
    {
        $this->quantity_remain = $this->quantity_remain+$amount;

        return $this;
    }

    public function getQuantityRemain()
    {
        return $this->quantity_remain;
    }

    public function getCost()
    {
        return round($this->quantity * $this->price, 8);
    }

    public function getCostRemain()
    {
        return round($this->quantity_remain * $this->price, 8);
    }

    public function getDate()
    {
        return $this->date;
    }

    public function getTrader() : Trader
    {
        return $this->trader;
    }

    public function getPair() : Pair
    {
        return $this->pair;
    }
}