<?php

namespace Hydraex\Exchange\Interfaces\Entities;

interface Pair
{
    public function getPrimary() : Asset;

    public function getSecondary() : Asset;
}