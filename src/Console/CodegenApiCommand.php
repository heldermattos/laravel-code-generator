<?php

namespace VictorYoalli\LaravelCodeGenerator\Console;

use Illuminate\Console\Command;
use VictorYoalli\LaravelCodeGenerator\ModelLoader;
use VictorYoalli\LaravelCodeGenerator\Facades\CodeHelper;
use VictorYoalli\LaravelCodeGenerator\Facades\CodeGenerator;

function printif($type, $filename, $msg = '✖ Not generated ')
{
    echo($filename === '' ? $msg . ' : ' . $type : "✔ {$filename}") . "\n";
}

class CodegenApiCommand extends Command
{
    protected $signature = 'codegen:api {model} ' . 
        '{--namespace=App\Models : Models Namespace} ' .
        '{--t|template= : template location} ' .
        '{--o|outfile= : Output file location} ' .
        '{--theme=api : Theme} ' .
        '{--apiversion=V1 : Api Version}';

    protected $description = 'A Laravel Code Generator based on your Models.';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle(ModelLoader $loader)
    {
        // many changes to make, massa
        $model = $this->argument('model');

        if (empty($model)) {
            return;
        }

        $theme = $this->option('theme');
        $version = $this->option('apiversion');

        $options = compact(['theme', 'version']);
        
        $namespace = rtrim($this->option('namespace'), '\\');
        $model = "{$namespace}\\{$model}";
        $m = $loader->load($model);

        $this->generate($m, $options, $theme, true);
    }

    public function generate($m, $options, $theme, $force)
    {
        $option = (object) $options;
        $folder = CodeHelper::plural($m->name);
        $base_path = "app/Api/{$option->version}/{$folder}";

        printif('API Controller', CodeGenerator::generate(
            $m,
            $theme . '/Http/Controllers/ModelApiController',
            "{$base_path}/Http/Controllers/{$folder}Controller.php", $force, $options
        ));

        printif('API Resource', CodeGenerator::generate(
            $m,
            $theme . '/Http/Resources/Model',
            "{$base_path}/Http/Resources/{$m->name}.php", $force, $options
        ));

        printif('API Collection', CodeGenerator::generate(
            $m,
            $theme . '/Http/Resources/ModelCollection',
            "{$base_path}/Http/Resources/{$m->name}Collection.php", $force, $options
        ));

        printif('API Routes', CodeGenerator::generate(
            $m,
            $theme . '/Http/Routes/index',
            "{$base_path}/Http/Routes/index.php", $force, $options
        ));

        printif('API Repository', CodeGenerator::generate(
            $m,
            $theme . '/Repository/ModelRepository',
            "{$base_path}/Repository/{$folder}Repository.php", $force, $options
        ));
    }
}
