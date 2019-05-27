<?php

namespace Hydraex\Exchange\Entities;

class Pair implements \Hydraex\Exchange\Interfaces\Entities\Pair
{
    private $primary;
    private $secondary;

    public function __construct(Asset $primary, Asset $secondary)
    {
        $this->primary = $primary;
        $this->secondary = $secondary;
    }

    public function getPrimary() : Asset
    {
        return $this->primar;
    }

    public function getSecondary() : Asset
    {
        return $this->secondary;
    }
}