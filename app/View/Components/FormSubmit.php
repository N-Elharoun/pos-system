<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class FormSubmit extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public $text = "submit",
        public $formId = "main-form"
    ) {
       //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('admin.components.form-submit');
    }
}
