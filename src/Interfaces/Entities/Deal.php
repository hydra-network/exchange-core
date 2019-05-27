<?php

namespace Hydra\Exchange\Interfaces\Entities;

use App\Models\Order;

interface Deal
{
    public function getPrice() : int;

    public function getQuantity() : int;

    public function getBuyOrder() : Order;

    public function getSellOrder() : Order;

    public function execute() : self;
}