<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class map extends Component
{
    public $lat;
    public $lon;

    public $locations;
    /**
     * Create a new component instance.
     */
    public function __construct($lat, $lon, $locations)
    {
        $this->lat = $lat;
        $this->lon = $lon;
        $this->locations = $locations;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.map');
    }
}
