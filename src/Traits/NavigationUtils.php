<?php

namespace Dlogon\QuickCrudForLaravel\Traits;

use Illuminate\Support\Arr;

/**
 * Note: This is a preview of an upcoming package from Tighten.
 **/
trait NavigationUtils
{
    public function getRelatedModelProperty(string $dotRelatedField)
    {
        return Arr::get($this, $dotRelatedField, '');
    }

    public function getNextRecordAttribute()
    {
        return self::where('id', '>', $this->id)->min('id');
    }

    public function getPreviousRecordAttribute()
    {
        return self::where('id', '<', $this->id)->max('id');
    }

    public function callFunctionFromRelatedCollection($related, $function)
    {
        $collection = $this->getRelatedModelProperty($related);

        // return $collection;
        return call_user_func_array([
            $collection,
            $function,
        ], []);
    }
}
