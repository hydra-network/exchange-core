<?php

namespace Hydra\Exchange\Interfaces\Entities;

interface Pair
{
    public function getPrimary() : Asset;

    public function getSecondary() : Asset;
}