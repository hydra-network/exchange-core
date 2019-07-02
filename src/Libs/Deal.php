<?php

namespace Hydra\Exchange\Libs;

use \Hydra\Exchange\Interfaces\Entities\Order as iOrder;
use \Hydra\Exchange\Interfaces\Libs\Deal as iDeal;

class Deal implements iDeal, \Hydra\Exchange\Interfaces\ToArrayable
{
    private $quantity;
    private $price;
    private $buyOrder;
    private $sellOrder;
    private $executedAt;
    private $type;

    const TYPE_SELLER_TAKER = 1;
    const TYPE_BUYER_TAKER = 2;

    public function __construct($price, iOrder $buyOrder, iOrder $sellOrder)
    {
        $this->price = $price;
        $this->buyOrder = $buyOrder;
        $this->sellOrder = $sellOrder;
    }

    public function getPrice() : float
    {
        return $this->price;
    }

    public function getQuantity() : float
    {
        return $this->quantity;
    }

    public function getType() : int
    {
        return $this->type;
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
            Logger::write("Both orders are filled");

            $this->quantity = $buyerBid->getQuantityRemain();
            $sellerBid->removeQuantity();
            $buyerBid->removeQuantity();
        } elseif ($buyerBid->getQuantityRemain() < $sellerBid->getQuantityRemain()) {
            Logger::write("Buyers's order has filled");

            $this->quantity = $buyerBid->getQuantityRemain();
            $sellerBid->minusQuantity($this->quantity);
            $buyerBid->removeQuantity();
        } else {
            Logger::write("Seller's order has filled");

            $this->quantity = $sellerBid->getQuantityRemain();
            $buyerBid->minusQuantity($this->quantity);
            $sellerBid->removeQuantity();
        }

        $this->type = $this->detectType();

        if ($this->type == Deal::TYPE_BUYER_TAKER) {
            Logger::write("The buyer is taker");
        } else {
            Logger::write("The seller is taker");
        }


        $cost = $this->quantity * $this->price;

        Logger::write("The cost is $cost, quantity is {$this->quantity}");

        $buyerBid->getBalance()->outcomePrimary($cost);
        $sellerBid->getBalance()->outcomeSecondary($this->quantity);

        $buyerBid->getBalance()->incomeSecondary($this->quantity);
        $sellerBid->getBalance()->incomePrimary($cost);

        $this->executedAt = time();

        Logger::write("Executed at {$this->executedAt}");

        return $this;
    }

    protected function detectType()
    {
        if ($this->sellOrder->getOrderNumber() > $this->buyOrder->getOrderNumber()) {
            return self::TYPE_BUYER_TAKER;
        } else {
            return self::TYPE_SELLER_TAKER;
        }
    }

    public function toArray() : array
    {
        return [
            'price' => $this->getPrice(),
            'quantity' => $this->getQuantity(),
            'type' => $this->type,
        ];
    }
}