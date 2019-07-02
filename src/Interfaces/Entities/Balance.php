<?php

namespace Hydra\Exchange\Interfaces\Entities;

interface Balance
{
    public function getOwnerType() : string;

    public function getPrimary() : float;

    public function getSecondary() : float;

    public function outcomePrimary(float $quantity) : Balance;

    public function outcomeSecondary(float $quantity) : Balance;

    public function incomePrimary(float $quantity) : Balance;

    public function incomeSecondary(float $quantity) : Balance;
}