<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SessionController extends Controller
{
  public function index()
  {
    return view('admin.login');
  }

  public function signin()
  {
    return redirect()->route('admin.list');
  }

  public function signout()
  {

  }
}
