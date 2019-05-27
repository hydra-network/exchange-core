<?php

namespace Hydra\Exchange\Entities;

use \Hydra\Exchange\Interfaces\Entities\Asset as iAsset;

class Pair implements \Hydra\Exchange\Interfaces\Entities\Pair
{
    private $primary;
    private $secondary;

    public function __construct(Asset $primary, Asset $secondary)
    {
        $this->primary = $primary;
        $this->secondary = $secondary;
    }

    public function getPrimary() : iAsset
    {
        return $this->primar;
    }

    public function getSecondary() : iAsset
    {
        return $this->secondary;
    }
}