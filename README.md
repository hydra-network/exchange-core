# Exchange core

Matcher allows to exchange any assets with the changing of trader's balances and volumes of each order in order book.

## Install

Via Composer:

```
php composer require hydraex/exchange
```

## Basic case of usage

```php
//...
use Hydra\Exchange\Entities\Pair;
use Hydra\Exchange\Entities\BuyOrder;
use Hydra\Exchange\Entities\SellOrder;
use Hydra\Exchange\Entities\SellerBalance;
use Hydra\Exchange\Entities\BuyerBalance;
use Hydra\Exchange\Entities\Asset;
use Hydra\Exchange\Libs\Matcher;
use Hydra\Exchange\Libs\Logger;
//...

//creation of pair
$pair = new Pair(
    new Asset("BTC", "Bitcoin"), //primary asset
    new Asset("ETH", "Ether") //secondary asset
);

//setting of user balances
$buyersBalance = new BuyerBalance(1001, 89);
$sellerBalance = new SellerBalance(99, 11);

//two counter orders:
//one wants to buy 100 units of the ETH for the price of 10
$buyOrder = new BuyOrder($pair, 100, 10, $buyersBalance, 1);
//another wants to sell 10 units of the ETH for the price of 9
$sellOrder = new SellOrder($pair, 10, 9, $sellerBalance, 2);
//(the last parameter (1 and 2) is order number among all orders)

//deal with it:
$matcher = new Matcher($buyOrder, $sellOrder);
$deal = $matcher->matching();

echo "Deal price is " . $deal->getPrice() . "\n";
echo "Deal quantity is " . $deal->getQuantity() . "\n";
echo "Buyer BTC balance is " . $buyersBalance->getPrimary() . "\n";
echo "Buyer ETH balance is " . $buyersBalance->getSecondary() . "\n";
echo "Seller BTC balance is " . $sellerBalance->getPrimary() . "\n";
echo "Seller ETH balance is " . $sellerBalance->getSecondary() . "\n";
echo "Buy order now contains only " . $buyOrder->getQuantityRemain() . " ETH \n";
echo "Sell order now contains " . $buyOrder->getQuantityRemain() . " ETH and his status is " . $sellOrder->getStatus() . "\n";
echo "Log: ";
var_dump(Logger::list());
```