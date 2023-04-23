<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SessionController extends Controller
{
  public function index()
  {
    $this->set_default();
    return view('admin.login', $this->data);
  }

  public function signin()
  {
    return redirect()->route('admin.list');
  }

  public function signout()
  {

  }
}
