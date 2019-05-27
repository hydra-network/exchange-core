<?php

namespace Hydra\Exchange\Interfaces\Entities;

interface Balance
{
    public function getPrimary() : int;

    public function getSecondary() : int;

    public function outcomePrimary(int $quantity) : self;

    public function outcomeSecondary(int $quantity) : self;

    public function incomePrimary(int $quantity) : self;

    public function incomeSecondary(int $quantity) : self;
}