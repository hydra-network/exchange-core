<?php

namespace Hydra\Exchange\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Hydra\Exchange\Entities\Pair;
use Hydra\Exchange\Entities\BuyOrder;
use Hydra\Exchange\Entities\SellOrder;
use Hydra\Exchange\Entities\SellerBalance;
use Hydra\Exchange\Entities\BuyerBalance;
use Hydra\Exchange\Entities\Asset;
use Hydra\Exchange\Libs\Matcher;
use Hydra\Exchange\Libs\Logger;

class MatchingTest extends TestCase
{
    /**
     * @return void
     */
    public function testBuyOneOrder()
    {
        $sellerBalance = new SellerBalance(100, 99);
        $buyersBalance = new BuyerBalance(99, 89);

        //Check balance before
        $this->assertEquals(100, $sellerBalance->getPrimary());
        $this->assertEquals(99, $sellerBalance->getSecondary());
        $this->assertEquals(99, $buyersBalance->getPrimary());
        $this->assertEquals(89, $buyersBalance->getSecondary());

        $pair = new Pair(
            new Asset("BTC", "Bitcoin"), //primary asset
            new Asset("ETH", "Ether") //secondary asset
        );

        $buyOrder = new BuyOrder($pair, 100, 100, $buyersBalance, 2);
        $sellOrder = new SellOrder($pair, 10, 99, $sellerBalance, 1);

        $matcher = new Matcher($buyOrder, $sellOrder);
        $deal = $matcher->matching();

        //Check deal result
        $this->assertEquals(1, $deal->getType());
        $this->assertEquals(100, $deal->getPrice());
        $this->assertEquals(10, $deal->getQuantity());


        //Check balance after
        $this->assertEquals(1100, $sellerBalance->getPrimary());
        $this->assertEquals(89, $sellerBalance->getSecondary());
        $this->assertEquals(-901, $buyersBalance->getPrimary());
        $this->assertEquals(99, $buyersBalance->getSecondary());



        echo '===========';
        var_dump(Logger::list());
        echo '===========';
    }
}
