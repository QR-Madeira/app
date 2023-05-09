<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class a extends Component
{
    public $name;
    public $url;
    public $color;
    /**
     * Create a new component instance.
     */
    public function __construct($name, $url, $color = 'black')
    {
        $this->name = $name;
        $this->url = $url;
        $this->color = $color;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.a');
    }
}
