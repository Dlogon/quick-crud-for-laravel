<?php

namespace Dlogon\QuickCrudForLaravel\Commands;

use Exception;

class CreateAllCommand extends BaseClassCommand
{
    public $signature = 'quickcrud:all {name} {nameSpace=App\Models\}';

    public $description = 'Create views and controller of model';

    public function handle(): int
    {
        try {
            $this->comment('Building things');
            $name = $this->getNameInput();
            $modelNameSpaceProvided = $this->argument('nameSpace');

            $this->call('quickcrud:create', ['name' => $name, 'nameSpace' => $modelNameSpaceProvided]);
            $this->call('quickcrud:views', ['name' => $name]);

            return self::SUCCESS;
        } catch (Exception $e) {
            $this->warn('error creating files');
        }
    }

    protected function getStub()
    {
    }
}
