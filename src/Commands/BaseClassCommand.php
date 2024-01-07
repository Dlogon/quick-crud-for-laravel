<?php

namespace Dlogon\QuickCrudForLaravel\Commands;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Facades\View;

abstract class BaseClassCommand extends GeneratorCommand
{
    protected function checkIfFileExist($name): bool
    {
        if ($this->alreadyExists($name)) {
            $this->error($this->type.' already exists!');

            return true;
        }
        if (View::exists($name)) {
            $this->error($this->type.' already exists!');

            return true;
        }

        return false;
    }
}
