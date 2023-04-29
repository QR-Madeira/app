<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

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
        'email' => 'required|email',
        'password' => 'required'
      ]);

      if (Auth::attempt($data, $request->has('remember'))) {
        $request->session()->regenerate();
        return redirect()->route('admin.main');
      }else{
        return redirect()->route('login');
      }

    }

    public function signout()
    {
      Session::flush();
      Auth::logout();
      return redirect()->route('login');
    }
}
