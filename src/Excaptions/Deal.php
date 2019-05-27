<?php

namespace Hydra\Exchange\Excaptions;

class Deal extends \Exception
{
    public function __construct($message, $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}