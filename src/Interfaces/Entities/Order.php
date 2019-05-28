<?php

namespace Hydra\Exchange\Interfaces\Entities;

interface Order
{
    public function getStatus() : int;

    public function getType() : int;

    public function getPrice() : int;

    public function getQuantity() : int;

    public function removeQuantity() : Order;

    public function minusQuantity(int $amount) : Order;

    public function plusQuantity(int $amount) : Order;

    public function getQuantityRemain() : int;

    public function getCost() : int;

    public function getCostRemain() : int;

    public function getOrderNumber() : int; //id

    public function getBalance() : Balance;

    public function getPair() : Pair;
}