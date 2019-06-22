<?php

namespace Hydra\Exchange\Libs;

use Hydra\Exchange\Interfaces\Entities\Order as iOrder;
use Hydra\Exchange\Exceptions\Deal as DealException;

class Matcher
{
    private $buyOrder;
    private $sellOrder;

    public function __construct(iOrder $buyOrder, iOrder $sellOrder)
    {
        $this->buyOrder = $buyOrder;
        $this->sellOrder = $sellOrder;
    }

    public function getBuyOrder() : iOrder
    {
        return $this->buyOrder;
    }

    public function getSellOrder() : iOrder
    {
        return $this->sellOrder;
    }

    public function matching() : ?Deal
    {
        Logger::write("Matching inited");

        $buyerBid = $this->buyOrder;
        $sellerBid = $this->sellOrder;

        if ($buyerBid->getQuantityRemain() > 0 && $buyerBid->getPrice() >= $sellerBid->getPrice()) {
            $buyerBid->unfreezeBalance();
            $sellerBid->unfreezeBalance();

            $price = self::detectPrice($buyerBid, $sellerBid);

            Logger::write("Orders are matched, the price is $price");

            $deal = new Deal($price, $buyerBid, $sellerBid);

            if ($deal->execute()) {
                Logger::write("Deal successfully created");

                return $deal;
            } else {
                throw new DealException("Unable to execute the deal");
            }
        }

        return null;
    }

    private static function detectPrice($buyerBid, $sellerBid)
    {
        if ($sellerBid->getOrderNumber() > $buyerBid->getOrderNumber()) {
            $price = $buyerBid->getPrice();
        } else {
            $price = $sellerBid->getPrice();
        }

        return $price;
    }
}