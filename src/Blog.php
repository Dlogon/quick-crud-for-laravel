<?php

namespace Dlogon\QuickCrudForLaravel;

use Dlogon\QuickCrudForLaravel\Database\Factories\BlogFactory;
use Dlogon\QuickCrudForLaravel\Traits\NavigationUtils;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;
    use NavigationUtils;

    /**
     * Create a new factory instance for the model.
     */
    protected static function newFactory()
    {
        return BlogFactory::new();
    }
}
