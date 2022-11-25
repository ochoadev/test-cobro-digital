<?php

namespace Interpreter;

interface Strategy 
{
    public function process_file($file);
}