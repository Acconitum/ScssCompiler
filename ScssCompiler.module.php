<?php

namespace ProcessWire;

use MenthaWeb\ProcesswireScssCompiler\Compiler;

class ScssCompiler extends WireData implements Module, ConfigurableModule
{
    public static function getModuleInfo()
    {
        return [
            'title' => 'SCSS Compiler',
            'summary' => 'SCSS compiler with a tiny SCSS framework for ProcessWire',
            'version' => '1.0',
            'autoload' => true
        ];
    }

    public static function getModuleConfigInputfields(array $data)
    {
        $fields = new InputfieldWrapper();

        $field = wire('modules')->get('InputfieldText');
        $field->attr('name+id', 'variables');
        $field->attr('value', $data['variables']);
        $field->label = 'SCSS variables file';
        $field->description = 'Path to the file containing the scss-variables inside the templates directory (E.g assets/src/critical.scss)';
        $fields->append($field);

        $field = wire('modules')->get('InputfieldText');
        $field->attr('name+id', 'critical');
        $field->attr('value', $data['critical']);
        $field->label = 'Critical import file';
        $field->description = 'Path to the file containing the critical scss inside the templates directory (E.g assets/src/main.scss)';
        $fields->append($field);

        $field = wire('modules')->get('InputfieldText');
        $field->attr('name+id', 'main');
        $field->attr('value', $data['main']);
        $field->label = 'Main import file';
        $field->description = 'Path to the file containing the main scss inside the templates directory';
        $fields->append($field);

        $field = wire('modules')->get('InputfieldText');
        $field->attr('name+id', 'destination');
        $field->attr('value', $data['destination']);
        $field->attr('required', 'true');
        $field->label = 'Destination directory';
        $field->description = 'Path to the directory where the compiled critical.scss and main.scss should be saved inside the templates directory. The files provided are named critical.min.css and main.min.css';
        $fields->append($field);

        return $fields; 
    }

    public function ready()
    {
        if (!file_exists(__DIR__ . '/vendor/autoload.php')) {
            $this->error('autoload.php not found!');
            return;
        }

        if (wire('config')->debug === false) {
            return;
        }

        require __DIR__ . '/vendor/autoload.php';
        $scssCompiler = new Compiler($this);
        $scssCompiler->compile();
    }
}
