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

    const TYPE_BID_SELLER = 1;
    const TYPE_BID_BUYER = 2;

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

        if ($this->type == Deal::TYPE_BID_BUYER) {
            Logger::write("Buyer is BID and seller is ASK");
        } else {
            Logger::write("Seller is BID and seller is BID");
        }


        $cost = round($this->quantity * $this->price);

        Logger::write("The cost is $cost, quantity is {$this->quantity}");

        $buyerBid->getBalance()->outcomePrimary($cost);
        $sellerBid->getBalance()->outcomeSecondary($this->quantity);

        $buyerBid->getBalance()->incomeSecondary($this->quantity);
        $sellerBid->getBalance()->incomePrimary($cost);

        $this->executedAt = time();

        Logger::write("Exacuted at {$this->executedAt}");

        return $this;
    }


    private function detectType()
    {
        if ($this->sellOrder->getOrderNumber() > $this->buyOrder->getOrderNumber()) {
            return self::TYPE_BID_BUYER;
        } else {
            return self::TYPE_BID_SELLER;
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