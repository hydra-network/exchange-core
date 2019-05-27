<?php

namespace Hydra\Exchange\Interfaces\Entities;

interface Deal
{
    public function getPrice() : int;

    public function getQuantity() : int;

    public function getBuyOrder() : Order;

    public function getSellOrder() : Order;

    public function execute() : Deal;
}