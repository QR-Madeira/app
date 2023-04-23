<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\App;

class Controller extends BaseController
{
  protected $data;

  use AuthorizesRequests, ValidatesRequests;
  
  protected function set_default()
  {
    $this->set_data('current', strtoupper(app()->getLocale()));
  }

  protected function set_data($key, $value)
  {
    $this->data[$key] = $value;
  }
}
