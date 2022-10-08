<?php

namespace MenthaWeb\ProcesswireScssCompiler;

use ProcessWire\WireData;
use ScssPhp\ScssPhp\Compiler as ScssPhpCompiler;

class Compiler extends WireData
{
    protected $config;
    protected $scssCompiler;

    public function __construct($config)
    {
        $this->config = $config;
        $this->scssCompiler = new ScssPhpCompiler();
    }

    public function compile()
    {


    }
}