<?php

namespace Dlogon\QuickCrudForLaravel\Helpers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;

class Search
{
    public static function searchByQueryParams(Model $model, Request $request)
    {
        $collection = new Collection();
        $query = $model::query();
        if($request->has('q'))
        {
            $querystring = $request->input('q');
            //dd($querystring);
            foreach($querystring as $field=>$searchObj)
            {
                $sObject =  json_decode($searchObj, true);
                $type = $sObject['type'];
                $value = $sObject['value'];
                switch($type)
                {
                    case "text":
                            $query->where($field, 'like', "%$value%");
                        break;
                    case "related":
                            $query->where($field, $value);
                        break;
                    case "single-date":
                            $query->whereDate($field, $value);
                        break;

                }
                // if($key == "customCallback")
                // {
                //     $searchObjects = json_decode($value);
                //     foreach($searchObjects->callbacks as $el => $searchObject)
                //     {
                //         $function = $searchObject->customCallback;
                //         $models = call_user_func(array($model, $function), [$searchObject->key => $searchObject->data]);
                //         $collection->count() == 0 ?
                //             $collection=$collection->merge($models) :
                //             $collection=$collection->intersect($models);
                //     }
                // }
                // else if($value)
                // {

                //     $query->where($key, 'like', "%$value%");
                // }
            }
        }
        return $query;
    }
}
