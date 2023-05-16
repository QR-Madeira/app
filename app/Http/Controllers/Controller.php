<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use App\Classes\Data;

class Controller extends BaseController
{
    protected $data;

    use AuthorizesRequests;
    use ValidatesRequests;

    protected function view($view)
    {
      $this->data->set('isLogged', Auth::check());

      $this->data->set('userName', Auth::check() ? Auth::user()->name : null);

      return view($view, $this->data->get());
    }

    public function __construct()
    {
      $this->data = Data::getInstance();
    }

    public function error($error)
    {
      session()->flash('error', $error);
      return redirect()->back();
    }
}
