<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\App;
use App\Classes\Data;

class Controller extends BaseController
{
  protected $data;

  use AuthorizesRequests;
  use ValidatesRequests;

  protected function view($view)
  {
    return view($view, $this->data->get());
  }

  public function __construct()
  {
    $this->data = Data::getInstance();
  }
}
