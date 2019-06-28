<?php

namespace Hydra\Exchange\Entities;

class Asset implements \Hydra\Exchange\Interfaces\Entities\Asset
{
    private $code;
    private $name;

    public function __construct(string $code, string $name = '')
    {
        if (!$name) {
            $name = $code;
        }

        $this->code = $code;
        $this->name = $name;
    }

    public function getCode() : string
    {
        return $this->code;
    }

    public function getName() : string
    {
        return $this->name;
    }
}