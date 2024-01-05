<?php

namespace Dlogon\QuickCrudForLaravel\Commands;

use Illuminate\Console\Command;
use Illuminate\Console\GeneratorCommand;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Dlogon\QuickCrudForLaravel\QuickCrudForLaravel;
use Illuminate\Support\Str;
use InvalidArgumentException;


class QuickCrudForLaravelCommand extends GeneratorCommand
{
    public $signature = 'quickcrud:create {name}';

    public $description = 'My command';

    protected $fields = [];
    protected $controllerName = "";
    protected $modelNameSpace = "";
    protected $modelName = "";

        /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__ . '/../resources/stubs/controller.stub';
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\Http\Controllers';
    }

    public function handle(): int
    {
        $this->modelName = $this->getNameInput();
        $this->controllerName = $this->modelName.'Controller';
        $name = $this->qualifyClass($this->controllerName);
        $path = $this->getPath($name);

        if ($this->alreadyExists($this->getNameInput())) {
            $this->error($this->type . ' already exists!');

            return false;
        }


        $this->modelNameSpace = QuickCrudForLaravel::MODEL_NAME_SPACE.$this->modelName;
        $model = new $this->modelNameSpace;
        $columns = QuickCrudForLaravel::describeModel($model);
        $columns = \array_combine(\array_values($columns), \array_values($columns));

        $this->comment(\var_dump($columns));
        $this->comment($this->modelNameSpace);
        $this->comment($path);
        $this->fields = $columns;

        $this->makeDirectory($path);
        $this->files->put($path, $this->buildClass($name));

        $this->info($this->type . ' created successfully.');

        return self::SUCCESS;
    }

        /**
     * Build the class with the given name.
     *
     * Remove the base controller import if we are already in base namespace.
     *
     * @param  string  $name
     * @return string
     */
    protected function buildClass($name)
    {
        $controllerNamespace = $this->getNamespace($name);

        $replace["use {$controllerNamespace}\Controller;\n"] = '';
        $replace = array_merge($replace, [
            'DummyFields' => \var_export($this->fields, true) ,
            "DummyModel" => $this->modelName ,
            "DummySpaceModel" => $this->modelNameSpace
        ]);

        return str_replace(
            array_keys($replace),
            array_values($replace),
            parent::buildClass($name)
        );
    }
}
