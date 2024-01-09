<?php

namespace Dlogon\QuickCrudForLaravel\Components;

use Illuminate\View\Component;

class Table extends Component
{
    public $fields;

    public $searchFields;

    public $models;

    public $showButton;

    public $editButton;

    public $deleteButton;

    public $route;

    public $modelActions;

    public $paginate;

    public $actions;

    public $isSearch;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        $fields = [],
        $searchFields = [],
        $models = [],
        $showButton = true,
        $editButton = true,
        $deleteButton = false,
        $route = '/',
        $modelActions = [],
        $paginate = true,
        $actions = true,
    ) {
        $this->fields = $fields;
        $this->searchFields = $searchFields;
        $this->models = $models;
        $this->showButton = $showButton;
        $this->editButton = $editButton;
        $this->deleteButton = $deleteButton;
        $this->route = $route;
        $this->modelActions = $modelActions;
        $this->paginate = $paginate;
        $this->actions = $actions;
        $this->isSearch = $this->isSearch();
    }

    private function isSearch()
    {
        return \in_array('search', request()->segments());
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('quick-crud-for-laravel::components.table');
    }
}
