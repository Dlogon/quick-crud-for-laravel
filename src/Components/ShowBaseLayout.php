<?php

namespace Dlogon\QuickCrudForLaravel\Components;

use Dlogon\QuickCrudForLaravel\Helpers\RequestHelpers;
use Illuminate\Http\Request;
use Illuminate\View\Component;

class ShowBaseLayout extends Component
{
    public $nextRecord;

    public $previousRecord;

    public $routeNamme = '';

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->routeNamme = $request->route()->getName();
        $model = RequestHelpers::getModelFromShowView(request());
        $this->nextRecord = $model->getNextRecordAttribute();
        $this->previousRecord = $model->getPreviousRecordAttribute();

    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        //dd(\request());
        return view('quick-crud-for-laravel::layouts.base-show');
    }
}
