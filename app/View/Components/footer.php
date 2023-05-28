<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class footer extends Component
{
    public $site;

    public function __construct($site)
    {
        $this->site = $site;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.footer');
    }
}
