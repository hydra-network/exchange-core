<?php

namespace Hydra\Exchange\Interfaces\Entities;

interface Order
{

    public function getType() : int;

    public function getPrice() : int;

    public function getQuantity() : int;

    public function removeQuantity() : self;

    public function minusQuantity(int $amount) : self;

    public function plusQuantity(int $amount) : self;

    public function getQuantityRemain() : int;

    public function getCost() : int;

    public function getCostRemain() : int;

    public function getDate() : int; //timestamp

    public function getBalance() : Balance;

    public function getPair() : Pair;
}