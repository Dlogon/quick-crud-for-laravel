<?php

namespace Dlogon\QuickCrudForLaravel\Tests\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Dlogon\QuickCrudForLaravel\Traits\NavigationUtils;

class Blog extends Model
{
    use HasFactory;
    use NavigationUtils;
}
