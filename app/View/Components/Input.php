<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Input extends Component
{
    public $type;
    public $name;
    public $value;
    public $multiple;
    public $placeholder;
    /**
     * Create a new component instance.
     */
    public function __construct($type, $name, $value = null, $placeholder = null, $multiple = false)
    {
        $this->type = $type;
        $this->name = $name;
        $this->value = $value;
        $this->multiple = $multiple;
        $this->placeholder = $placeholder;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.input');
    }
}
