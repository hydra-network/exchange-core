<?php

namespace Tests\Unit;

use Tests\TestCase;
use Hydraex\Exchange\Entities\Pair;
use Hydraex\Exchange\Entities\BuyOrder;
use Hydraex\Exchange\Entities\SellOrder;
use Hydraex\Exchange\Entities\Balance;
use Hydraex\Exchange\Entities\Asset;
use Hydraex\Exchange\Libs\Matcher;

class MatchingTest extends TestCase
{
    /**
     * @return void
     */
    public function testBuyOneOrder()
    {
        $balances = [
            1 => new Balance(100, 100),
            2 => new Balance(99, 99),
            3 => new Balance(88, 88),
            4 => new Balance(87, 87),
            5 => new Balance(86, 86),
            6 => new Balance(85, 85),
            7 => new Balance(84, 84),
        ];

        $pair = new Pair(new Asset("BTC", "Bitcoin"), new Asset("ETH", "Ether"));

        $buyOrders = [
            new BuyOrder($pair, 100, 100, $balances[1], time() + 10),
            new BuyOrder($pair, 99, 101, $balances[2], time() + 20),
            new BuyOrder($pair, 98, 102, $balances[3], time() + 30),
            new BuyOrder($pair, 97, 103, $balances[1], time() + 40),
            new BuyOrder($pair, 96, 104, $balances[4], time() + 50),
            new BuyOrder($pair, 95, 105, $balances[5], time() + 60),
        ];

        $sellOrders = [
            new SellOrder($pair, 10, 102, $balances[3], time() + 5),
            new SellOrder($pair, 50, 101, $balances[4], time() + 6),
            new SellOrder($pair, 100, 100, $balances[5], time() + 7),
            new SellOrder($pair, 150, 99, $balances[6], time() + 8),
            new SellOrder($pair, 200, 98, $balances[7], time() + 9),
            new SellOrder($pair, 250, 97, $balances[6], time() + 10),
        ];

        $matcher = new Matcher($buyOrders, $sellOrders);
        $deals = $matcher->match()->getDeals();

        foreach ($deals as $deal) {
            var_dump($deal->toArray());
        }

        die;
    }
}
