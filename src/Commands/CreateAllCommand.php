<?php

namespace Dlogon\QuickCrudForLaravel\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class CreateAllCommand extends BaseClassCommand
{
    public $signature = 'quickcrud:all {name}';

    public $description = 'Create views and controller of model';

    public function handle(): int
    {
        $this->comment('Building things');
        $name = $this->getNameInput();

        Artisan::call("quickcrud:create" , ["name" => $name]);
        Artisan::call("quickcrud:views" , ["name" => $name]);
        return self::SUCCESS;

    }

    protected function getStub()
    {
        return;
    }

}
