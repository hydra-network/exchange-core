<?php

namespace Hydra\Exchange\Libs;

use Hydra\Exchange\Entities\Order;
use Hydra\Exchange\Entities\Deal;

class Matcher {
    private $buyOrders;
    private $sellOrders;
    private $deals;

    public function __construct($buyOrders, $sellOrders)
    {
        $this->buyOrders = $buyOrders;
        $this->sellOrders = $sellOrders;
    }

    public function getBuyOrders()
    {
        return $this->buyOrders;
    }

    public function getSellOrders()
    {
        return $this->sellOrders;
    }

    public function getDeals()
    {
        return $this->deals;
    }

    public function match()
    {
        $deals = [];
        foreach ($this->buyOrders as $key => $buyerBid) {
            foreach ($this->sellOrders as $sellerBid) {
                if ($buyerBid->getQuantityRemain() > 0 && $buyerBid->getPrice() >= $sellerBid->getPrice()) {
                    $price = self::detectPrice($buyerBid, $sellerBid);

                    $deal = new Deal($price, $buyerBid, $sellerBid);
                    $deal->execute();
                    $deals[] = $deal;
                }
            }
        }

        $this->deals = $deals;

        return $this;
    }

    private static function detectPrice($buyerBid, $sellerBid)
    {
        if ($sellerBid->getDate() > $buyerBid->getDate()) {
            $price = $buyerBid->getPrice();
        } else {
            $price = $buyerBid->getPrice();
        }

        return $price;
    }
}