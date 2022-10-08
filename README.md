# SCSS compiler for processwire

Contains a reset-css and basic container and section classes. There are several mixins to create grids or animations. For the compiling process the package scssphp/scssphp from [GitHub](https://github.com/scssphp/scssphp/).

## How it works

The module compiles given SCSS-files if $config->debug is true. First it will create a critical.min.css which then should be rendered into a style-tag inside head to avoid flashing navigations and prevent content shifts in the following order:

- Reset css from project-root/site/modules/ScssCompiler/scss/reset.scss
- Default variables project-root/site/modules/ScssCompiler/scss/variables.scss
- Variables from templates provided by $config->scssCompilerTemplateVariables
- Basic styles from project-root/site/modules/ScssCompiler/scss/base.scss
- Critical css from project-root/site/modules/ScssCompiler/scss/critical.scss
- Critical from templates provided by $config->scssCompilerCritical

Afterwards a file main.min.css will be created which should be included as link-tag inside the head with the following include order:

- Default variables project-root/site/modules/ScssCompiler/scss/variables.scss
- Variables from templates provided by $config->scssCompilerTemplateVariables
- Main css from project-root/site/modules/ScssCompiler/scss/main.scss
- Main from templates provided by $config->scssCompilerMain


## How to use


## Mixin reference