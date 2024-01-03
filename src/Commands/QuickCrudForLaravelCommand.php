<?php

namespace Dlogon\QuickCrudForLaravel\Commands;

use Illuminate\Console\Command;

class QuickCrudForLaravelCommand extends Command
{
    public $signature = 'quick-crud-for-laravel';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
