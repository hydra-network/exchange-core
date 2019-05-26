<?php

namespace Hydra\Exchange\Entities;

class Deal {
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

    public function getPrice()
    {
        return $this->price;
    }

    public function getQuantity()
    {
        return $this->quantity;
    }

    public function getBuyOrder()
    {
        return $this->buyOrder;
    }

    public function getSellOrder()
    {
        return $this->sellOrder;
    }

    public function execute()
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

        $buyerBid->getTrader()->newOutcome1($cost);
        $sellerBid->getTrader()->newOutcome2($this->quantity);

        $buyerBid->getTrader()->newIncome2($this->quantity);
        $sellerBid->getTrader()->newIncome1($cost);

        $this->executedAt = time();

        return $this;
    }

    public function toArray()
    {
        return [
            'price' => $this->getPrice(),
            'quantity' => $this->getQuantity(),
            'buy_order_id' => $this->getBuyOrder()->getId(),
            'sell_order_id' => $this->getSellOrder()->getId(),
        ];
    }
}