<?php

namespace Hydra\Exchange\Tools;

class Logger
{
    private $logs;

    public function write($message)
    {
        $this->logs[] = $message;
    }

    public function get()
    {
        return $this->logs;
    }
}