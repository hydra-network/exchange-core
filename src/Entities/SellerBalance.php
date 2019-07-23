<?php

namespace Hydra\Exchange\Entities;

use \Hydra\Exchange\Interfaces\Entities\Balance as iBalance;
use \Hydra\Exchange\Interfaces\Entities\Pair as iPair;

class SellerBalance extends Abstracts\Balance
{
    public function __construct(float $primary, float $secondary)
    {
        return parent::__construct($primary, $secondary, Abstracts\Balance::OWNER_TYPE_SELLER);
    }
}