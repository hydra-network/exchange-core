<?php

namespace Hydra\Exchange\Entities;

use \Hydra\Exchange\Interfaces\Entities\Order as iOrder;
use \Hydra\Exchange\Interfaces\Entities\Deal as iDeal;

class Deal implements \Hydra\Exchange\Interfaces\Entities\Deal, \Hydra\Exchange\Interfaces\ToArrayable
{
    private $quantity;
    private $price;
    private $buyOrder;
    private $sellOrder;
    private $executedAt;

    public function __construct($price, iOrder $buyOrder, iOrder $sellOrder)
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

    public function getBuyOrder() : iOrder
    {
        return $this->buyOrder;
    }

    public function getSellOrder() : iOrder
    {
        return $this->sellOrder;
    }

    public function execute() : iDeal
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

        $buyerBid->getBalance()->outcomePrimary($cost);
        $sellerBid->getBalance()->outcomeSecondary($this->quantity);

        $buyerBid->getBalance()->incomeSecondary($this->quantity);
        $sellerBid->getBalance()->incomePrimary($cost);

        $this->executedAt = time();

        return $this;
    }

    public function toArray() : array
    {
        return [
            'price' => $this->getPrice(),
            'quantity' => $this->getQuantity()
        ];
    }
}