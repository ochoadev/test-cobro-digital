<?php

namespace Interpreter;

use Interpreter\Strategy;

class Interpreter
{
    private Strategy $strategy;


    public function __construct(Strategy $strategy)
    {
        $this->strategy = $strategy;

    }

    public function set_strategy(Strategy $strategy) 
    {
        $this->strategy = $strategy;

    }

    public function process_file($file)
    {
        return $this->strategy->process_file($file);
    }
}