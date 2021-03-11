<?php

namespace VictorYoalli\LaravelCodeGenerator\Console;

use Illuminate\Console\Command;
use VictorYoalli\LaravelCodeGenerator\Facades\CodeHelper;
use VictorYoalli\LaravelCodeGenerator\Facades\CodeGenerator;

class CodegenConfigCommand extends Command
{
    protected $signature = 'codegen:config {config} ' . 
        '{--namespace=App\Models : Models Namespace} ' .
        '{--t|template= : template location} ' .
        '{--o|outfile= : Output file location} ' .
        '{--theme=apiconfig : Theme} ' .
        '{--apiversion=V1 : Api Version}';

    protected $description = 'A Laravel Code Generator based on your Config file.';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        // many changes to make, massa
        $config = $this->argument('config');

        if (empty($config)) {
            return;
        } 

        $theme = $this->option('theme');
        $version = $this->option('apiversion');

        $options = compact(['theme', 'version']);
        
        $m = config('microservices.'.$config);

        $this->generate($m, $options, $theme, true);
    }

    public function generate($m, $options, $theme, $force)
    {
        $option = (object) $options;
        $m = (object) $m;
        $folder = CodeHelper::plural($m->name);
        $base_path = "app/Api/{$option->version}/{$folder}";

        printif('API Controller', CodeGenerator::generate(
            $m,
            $theme . '/Http/Controllers/ModelApiController',
            "{$base_path}/Http/Controllers/{$m->name}Controller.php", $force, $options
        ));

        printif('API Routes', CodeGenerator::generate(
            $m,
            $theme . '/Http/Routes/index',
            "{$base_path}/Http/Routes/index.php", $force, $options
        ));
    }
}
