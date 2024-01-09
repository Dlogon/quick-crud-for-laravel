<?php

namespace Dlogon\QuickCrudForLaravel;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
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

    public static function getModelNames(): array
    {
        $models = [];
        $modelsPaths = config("traslations.models_folder", ["App\\Models\\" => app_path('Models')]);

        foreach($modelsPaths as $namespace => $path)
        {
            $modelFiles = File::allFiles($path);
            foreach ($modelFiles as $modelFile) {
                $modelName = $modelFile->getFilenameWithoutExtension();
                $models[] =  $modelName;
            }
        }
        return $models;
    }

    public static function tryResolveModelNameSpace(string $modelName)
    {

    }
}
