<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class attraction extends Component
{
  public $attraction;
    /**
     * Create a new component instance.
     */
    public function __construct($attraction)
    {
      $this->attraction = $attraction;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.attraction');
    }
}
