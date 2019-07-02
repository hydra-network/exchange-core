<?php

namespace Hydra\Exchange\Interfaces\Entities;

interface Order
{
    public function getStatus() : int;

    public function getType() : int;

    public function getPrice() : float;

    public function getQuantity() : int;

    public function removeQuantity() : Order;

    public function minusQuantity(int $amount) : Order;

    public function plusQuantity(int $amount) : Order;

    public function getQuantityRemain() : int;

    public function getCost() : float;

    public function getCostRemain() : float;

    public function getOrderNumber() : int; //id

    public function getBalance() : Balance;

    public function getPair() : Pair;
}