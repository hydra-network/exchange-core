<?php

namespace Hydra\Exchange\Interfaces\Libs;

use \Hydra\Exchange\Interfaces\Entities\Order as iOrder;

interface Deal
{
    public function getPrice() : int;

    public function getType() : int;

    public function getQuantity() : int;

    public function getBuyOrder() : iOrder;

    public function getSellOrder() : iOrder;

    public function execute() : Deal;
}