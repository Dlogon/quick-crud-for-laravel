<?php

namespace Dlogon\QuickCrudForLaravel\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Dlogon\QuickCrudForLaravel\QuickCrudForLaravel
 */
class QuickCrudForLaravel extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Dlogon\QuickCrudForLaravel\QuickCrudForLaravel::class;
    }
}
