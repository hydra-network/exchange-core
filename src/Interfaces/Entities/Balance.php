<?php

namespace Hydra\Exchange\Interfaces\Entities;

interface Balance
{
    public function getPrimary() : int;

    public function getSecondary() : int;

    public function outcomePrimary(int $quantity) : Balance;

    public function outcomeSecondary(int $quantity) : Balance;

    public function incomePrimary(int $quantity) : Balance;

    public function incomeSecondary(int $quantity) : Balance;
}