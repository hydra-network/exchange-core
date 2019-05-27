<?php

namespace Hydra\Exchange\Entities;

use \Hydra\Exchange\Interfaces\Entities\Balance as iBalance;
use \Hydra\Exchange\Interfaces\Entities\Pair as iPair;

class BuyerBalance extends Abstracts\Balance
{
    public function __construct(int $primary, int $secondary)
    {
        return parent::__construct($primary, $secondary, Abstracts\Balance::OWNER_TYPE_BUYER);
    }
}