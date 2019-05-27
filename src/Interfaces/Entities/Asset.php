<?php

namespace Hydra\Exchange\Interfaces\Entities;

interface Asset
{
    public function getCode() : string;

    public function getName() : string;
}