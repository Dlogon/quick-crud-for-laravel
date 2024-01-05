<?php

namespace Dlogon\QuickCrudForLaravel;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class QuickCrudForLaravel
{
    const MODEL_NAME_SPACE = 'App\\Models\\';

    public static function describeModel(Model|string $model)
    {

        $modelInstance = new $model;
        $table = $modelInstance->getTable();
        $tableColumns = Schema::getColumnListing($table);

        return $tableColumns;
    }

    public static function tryResolveModelNameSpace(string $modelName)
    {

    }
}
