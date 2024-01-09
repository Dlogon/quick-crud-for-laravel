<?php

namespace App\View\Components;

use App\Models\BaseModel;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class BaseShow extends Component
{
    public $header;

    public $fields;

    public BaseModel $model;

    public $chunkedFields;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        BaseModel $model,
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
    public function render(): View|Closure|string
    {
        return view('components.base-show');
    }
}
