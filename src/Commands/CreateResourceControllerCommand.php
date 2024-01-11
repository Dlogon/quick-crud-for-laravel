<?php

namespace Dlogon\QuickCrudForLaravel\Commands;

use Dlogon\QuickCrudForLaravel\QuickCrudForLaravel;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;

class CreateResourceControllerCommand extends BaseClassCommand
{
    public $signature = 'quickcrud:create {name}';

    public $description = 'Create the controller resource command';

    protected $fields = [];

    protected $controllerName = '';

    protected $modelNameSpace = '';

    protected $modelName = '';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__.'/../resources/stubs/controller.stub';
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace.'\Http\Controllers';
    }

    public function handle(): int
    {
        $this->modelName = $this->getNameInput();
        $this->controllerName = $this->modelName.'Controller';
        $name = $this->qualifyClass($this->controllerName);
        $path = $this->getPath($name);

        if ($this->checkIfFileExist($name)) {
            return self::FAILURE;
        }

        $this->modelNameSpace = 'App\\Models\\'.$this->modelName;
        $model = new $this->modelNameSpace;
        $columns = QuickCrudForLaravel::describeModel($model);
        $columns = \array_combine(\array_values($columns), \array_values($columns));

        $this->comment(\var_dump($columns));
        $this->comment($this->modelNameSpace);
        $this->comment($path);
        $this->fields = $columns;

        $this->makeDirectory($path);
        $this->files->put($path, $this->buildClass($name));

        $this->info($this->type.' created successfully.');

        $this->createOrUpdateRoutesCommand($name);

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
            'DummyFields' => \var_export($this->fields, true),
            'DummyModel' => $this->modelName,
            'DummySpaceModel' => $this->modelNameSpace,
            'Dummyfolder' => CreateViewsCommand::getDirectoryName($this->modelName),
        ]);

        return str_replace(
            array_keys($replace),
            array_values($replace),
            parent::buildClass($name)
        );
    }

    private function createOrUpdateRoutesCommand($name)
    {
        $controllerNamespace = $this->getNamespace($name);
        $files = new Filesystem;
        $fileRouteName = config('quick-crud-for-laravel.route_file_name');
        $files->ensureDirectoryExists(\base_path('routes'));
        $filePath = base_path("routes/$fileRouteName");
        $pluramModelName = Str::lower(Str::plural($this->modelName));
        $fullControllerNameSpace = $controllerNamespace.'\\'.$this->controllerName;

        if (! $files->exists($filePath)) {
            $files->copy(__DIR__.'/../resources/stubs/routes.stub', $filePath);
            $this->info('Routes file created!');
        }

        //Search route
        $files->append($filePath, "Route::get('$pluramModelName/search', [$fullControllerNameSpace::class , 'search']);\n");
        $files->append($filePath, "Route::resource('$pluramModelName', $fullControllerNameSpace::class);\n");

        $this->info('Routes file updated!');
    }
}
