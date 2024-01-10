<?php

namespace Dlogon\QuickCrudForLaravel\Helpers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class RequestHelpers
{
    public static function getModelFromShowView(Request $request)
    {
        $modelParameterName = $request->route()->parameterNames()[0];
        return $request->$modelParameterName ?? null;
    }

    public static function findModel(Request $request) : Model|null
    {
        foreach($request->route()->parameters() as $param)
        {
            if($param instanceof Model)
                return $param;
        }
        return null;
    }
}
