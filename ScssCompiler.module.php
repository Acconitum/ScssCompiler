<?php

namespace ProcessWire;


class ScssCompiler extends WireData implements Module {
  public static function getModuleInfo() {
    return [
      'title' => 'SCSS Compiler',
      'summary' => 'SCSS compiler with a tiny SCSS framework for ProcessWire',
      'version' => '1.0'
    ];
  }
}