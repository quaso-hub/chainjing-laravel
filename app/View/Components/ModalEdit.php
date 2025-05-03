<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ModalEdit extends Component
{
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

    public function render()
    {
        return view('components.modal-edit');
    }
}