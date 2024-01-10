<?php

namespace Dlogon\QuickCrudForLaravel\Components;

use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;
use Illuminate\View\Component;

class BaseShow extends Component
{
    public $header;

    public $fields;

    public Model $model;

    public $chunkedFields;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        Model $model,
        $header = '',
        $fields = []
    ) {
        $this->header = $header;
        $this->fields = $fields;
        $this->model = $model;
        $this->chunkedFields = \array_chunk($this->fields, 3, true);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {
        return view('quick-crud-for-laravel::components.base-show');
    }
}
