<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ModalCreate extends Component
{
    /**
     * Create a new component instance.
     */
    public $id, $labelledby, $title, $formId, $action, $submitText;

    public function __construct($id, $labelledby, $title, $formId, $action, $submitText)
    {
        $this->id = $id;
        $this->labelledby = $labelledby;
        $this->title = $title;
        $this->formId = $formId;
        $this->action = $action;
        $this->submitText = $submitText;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.modal-create');
    }
}
