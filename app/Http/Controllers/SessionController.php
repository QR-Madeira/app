<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class SessionController extends Controller
{
    public function index()
    {
      $this->set_default();
      return view('admin.login', $this->data);
    }

    public function signin(Request $request)
    {
      $data = $request->validate([
        'username' => 'required',
        'password' => 'required'
      ]);

      $given_username = $data['username'];
      $given_password = $data['password'];
      
      $given_password_hash = Hash::make($given_password);
      
      $user_get_validated = DB::table('users')->where('username', $given_username)->where('password', $given_password_hash)->first();
      if(!$user_get_validated)
        return redirect()->route('admin.login');

      $request->session()->put('username', $user_get_validated['username']);

      return redirect()->route('admin.list');
    }

    public function signout()
    {
    }
}
