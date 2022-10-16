<?php

namespace MenthaWeb\ProcesswireScssCompiler;

use ScssPhp\ScssPhp\Compiler as ScssPhpCompiler;
use ScssPhp\ScssPhp\OutputStyle;

/**
 * Compiles scss into css splitted by critical and main
 */
class Compiler
{
    /**
     * Name of the variables scss file
     */
    const VARIABLES_FILE = 'variables.scss';

    /**
     * Name of the critical scss file
     */
    const CRITICAL_FILE = 'critical.scss';

    /**
     * Name of the main scss file
     */
    const MAIN_FILE = 'main.scss';


    /**
     * ScssCompiler module
     * 
     * @var ScssCompiler
     */
    protected $module;

    /**
     * Path to the ScssCompiler module
     * 
     * @var string
     */
    protected $modulePath;

    /**
     * Path to the templates directory of the current site
     * 
     * @var string
     */
    protected $templatesPath;

    /**
     * Scss compiler
     * 
     * @var ScssPhp\ScssPhp\Compiler
     */
    protected $scssCompiler;

    /**
     * Sets default values
     * 
     * @param ScssCompiler $module
     */
    public function __construct($module)
    {
        $this->module = $module;
        $this->modulePath = $this->module->get('config')->path('ScssCompiler') . 'assets/';
        $this->templatesPath = $this->module->get('config')->path('templates');
        $this->scssCompiler = new ScssPhpCompiler();
        $this->scssCompiler->addImportPath($this->modulePath);
        $this->scssCompiler->setOutputStyle(OutputStyle::COMPRESSED);
    }

    /**
     * Extracts the SCSS files and compiles them into css
     */
    public function compile()
    {
        if (empty($this->module->destination)) {
            return;
        }

        $variablesScss = $this->gatherVariablesScss();
        $criticalScss = $this->gatherCriticalScss();
        $this->compileString('critical.min.css', $variablesScss . $criticalScss);

        $mainScss = $this->gatherMainScss();
        $this->compileString('main.min.css',  $variablesScss . $mainScss);
    }

    /**
     * Get all variables files in the right order
     * 
     * @return string
     */
    private function gatherVariablesScss()
    {
        $variablesScss = '';
        if (file_exists($this->modulePath . self::VARIABLES_FILE)) {
            $variablesScss .= $this->module->get('files')->fileGetContents($this->modulePath . self::VARIABLES_FILE);
        }

        if (!empty($this->module->variables) && file_exists($this->templatesPath . $this->module->variables)) {
            $variablesScss .= $this->module->get('files')->fileGetContents($this->templatesPath . $this->module->variables);
        }

        return $variablesScss;
    }

    /**
     * Get all critical files in the right order
     * 
     * @return string
     */
    private function gatherCriticalScss()
    {
        $criticalScss = '';
  
        if (file_exists($this->modulePath . self::CRITICAL_FILE)) {
            $criticalScss .= $this->module->get('files')->fileGetContents($this->modulePath . self::CRITICAL_FILE);
        }

        if (!empty($this->module->critical) && file_exists($this->templatesPath . $this->module->critical)) {
            $this->scssCompiler->addImportPath($this->templatesPath . dirname($this->module->critical));
            $criticalScss .= $this->module->get('files')->fileGetContents($this->templatesPath . $this->module->critical);
        }

        return $criticalScss;
    }

    /**
     * Get all main files in the right order
     * 
     * @return string
     */
    private function gatherMainScss()
    {
        $mainScss = '';
  
        if (file_exists($this->modulePath . self::MAIN_FILE)) {
            $mainScss .= $this->module->get('files')->fileGetContents($this->modulePath . self::MAIN_FILE);
        }

        if (!empty($this->module->main) && file_exists($this->templatesPath . $this->module->main)) {
            if (!in_array($this->templatesPath . dirname($this->module->main) ,$this->scssCompiler->getCompileOptions()['importPaths'])) {
                $this->scssCompiler->addImportPath($this->templatesPath . dirname($this->module->main));
            }
            $mainScss .= $this->module->get('files')->fileGetContents($this->templatesPath . $this->module->main);
        }

        return $mainScss;
    }

    /**
     * Compiles a string containing SCSS into css and saves 
     * the content to a file
     * 
     * @param string $name
     * @param string $content
     */
    private function compileString($name, $content)
    {
        try {
            $compiledScss = $this->scssCompiler->compileString($content);
            if (!empty($compiledScss->getCss())) {
                $this->module->get('files')->filePutContents($this->templatesPath . $this->module->destination . '/' . $name, $compiledScss->getCss());
            }
        } catch (\Throwable $th) {
            $this->module->error($th->getMessage());
        }
    }
}