<?php

namespace Hydra\Exchange\Interfaces\Libs;

use \Hydra\Exchange\Interfaces\Entities\Order as iOrder;

interface Deal
{
    public function getPrice() : float;

    public function getType() : int;

    public function getQuantity() : float;

    public function getBuyOrder() : iOrder;

    public function getSellOrder() : iOrder;

    public function execute() : Deal;
}