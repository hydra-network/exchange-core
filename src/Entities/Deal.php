<?php

namespace Hydraex\Exchange\Entities;

class Deal implements \Hydraex\Exchange\Interfaces\Entities\Deal, \Hydraex\Exchange\Interfaces\ToArrayable
{
    private $quantity;
    private $price;
    private $buyOrder;
    private $sellOrder;
    private $executedAt;

    public function __construct($price, Order $buyOrder, Order $sellOrder)
    {
        $this->price = $price;
        $this->buyOrder = $buyOrder;
        $this->sellOrder = $sellOrder;
    }

    public function getPrice() : int
    {
        return $this->price;
    }

    public function getQuantity() : int
    {
        return $this->quantity;
    }

    public function getBuyOrder() : Order
    {
        return $this->buyOrder;
    }

    public function getSellOrder() : Order
    {
        return $this->sellOrder;
    }

    public function execute() : self
    {
        $buyerBid = $this->buyOrder;
        $sellerBid = $this->sellOrder;

        if ($buyerBid->getQuantityRemain() == $sellerBid->getQuantityRemain()) {
            $this->quantity = $buyerBid->getQuantityRemain();
            $sellerBid->removeQuantity();
            $buyerBid->removeQuantity();
        } elseif ($buyerBid->getQuantityRemain() < $sellerBid->getQuantityRemain()) {
            $this->quantity = $buyerBid->getQuantityRemain();
            $sellerBid->minusQuantity($this->quantity);
            $buyerBid->removeQuantity();
        } else {
            $this->quantity = $sellerBid->getQuantityRemain();
            $buyerBid->minusQuantity($this->quantity);
            $sellerBid->removeQuantity();
        }

        $cost = round($this->quantity * $this->price, 8);

        $buyerBid->getBalance()->newOutcome1($cost);
        $sellerBid->getBalance()->newOutcome2($this->quantity);

        $buyerBid->getBalance()->newIncome2($this->quantity);
        $sellerBid->getBalance()->newIncome1($cost);

        $this->executedAt = time();

        return $this;
    }

    public function toArray() : array
    {
        return [
            'price' => $this->getPrice(),
            'quantity' => $this->getQuantity(),
            'buy_order_id' => $this->getBuyOrder()->getId(),
            'sell_order_id' => $this->getSellOrder()->getId(),
        ];
    }
}