<?php

namespace Dlogon\QuickCrudForLaravel\Tests\Models;

use Dlogon\QuickCrudForLaravel\Traits\NavigationUtils;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;
    use NavigationUtils;
}
