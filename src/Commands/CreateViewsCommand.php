<?php

namespace Dlogon\QuickCrudForLaravel\Commands;

use Illuminate\Support\Str;

class CreateViewsCommand extends BaseClassCommand
{
    public $signature = 'quickcrud:views {name}';

    public $description = 'Create the crud views';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub(): array
    {
        return [
            'index.blade.php' => __DIR__.'/../resources/stubs/index.stub',
            'show.blade.php' => __DIR__.'/../resources/stubs/show.stub',
        ];
    }

    protected function getPath($name)
    {
        return resource_path('views/crudable/'.self::getDirectoryName($name));
    }

    public static function getDirectoryName($name)
    {
        return Str::lower(Str::camel($name));
    }

    public function handle(): int
    {
        $this->comment('Building new Crudable views.');
        $name = $this->getNameInput();
        $path = $this->getPath($name);
        $stubs = $this->getStub();

        foreach ($stubs as $nameView => $stub) {
            $view = $path.'/'.$nameView;
            $this->comment($view);
            if ($this->checkIfFileExist($view)) {
                continue;
            }

            $this->makeDirectory($view);
            $this->files->put($view, $this->buildView($name, $stub));
            $this->info($this->type.' created successfully.');
        }

        return self::SUCCESS;

    }

    protected function generateClass($name, $stub)
    {
        $stub = $this->files->get($stub);

        return $this->replaceNamespace($stub, $name)->replaceClass($stub, $name);
    }

    protected function buildView($name, $stub)
    {
        $pluramModelName = Str::lower(Str::plural($name));
        $replace = [
            'DummyModelName' => $pluramModelName,
        ];

        return str_replace(
            array_keys($replace),
            array_values($replace),
            $this->generateClass($name, $stub)
        );
    }
}
