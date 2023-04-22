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
    $validatedData = $request->validate([
      'title' => 'required',
      'password' => 'required'
    ]);
  }

  public function signout()
  {

  }
}
