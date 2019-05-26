<?php

namespace Tests\Unit;

use Tests\TestCase;
use Hydra\Exchange\Entities\Pair;
use Hydra\Exchange\Entities\Order;
use Hydra\Exchange\Entities\Trader;
use Hydra\Exchange\Entities\Currency;
use Hydra\Exchange\Libs\Matcher;

class MatchingTest extends TestCase
{
    /**
     * @return void
     */
    public function testBuyOneOrder()
    {
        $traders = [
            1 => new Trader(100, 100),
            2 => new Trader(99, 99),
            3 => new Trader(88, 88),
            4 => new Trader(87, 87),
            5 => new Trader(86, 86),
            6 => new Trader(85, 85),
            7 => new Trader(84, 84),
        ];

        $pair = new Pair(new Currency("BTC", "Bitcoin"), new Currency("ETH", "Ether"));

        $buyOrders = [
            new Order(1, $pair, 100, 100, $traders[1], 10),
            new Order(2, $pair, 99, 101, $traders[2], 20),
            new Order(3, $pair, 98, 102, $traders[3], 30),
            new Order(4, $pair, 97, 103, $traders[1], 40),
            new Order(5, $pair, 96, 104, $traders[4], 50),
            new Order(6, $pair, 95, 105, $traders[5], 60),
        ];

        $sellOrders = [
            new Order(7, $pair, 10, 102, $traders[3], 5),
            new Order(8, $pair, 50, 101, $traders[4], 6),
            new Order(9, $pair, 100, 100, $traders[5], 7),
            new Order(10, $pair, 150, 99, $traders[6], 8),
            new Order(11, $pair, 200, 98, $traders[7], 9),
            new Order(12, $pair, 250, 97, $traders[6], 10),
        ];

        $matcher = new Matcher($buyOrders, $sellOrders);
        $deals = $matcher->match()->getDeals();

        foreach ($deals as $deal) {
            var_dump($deal->toArray());
        }

        die;
    }
}
