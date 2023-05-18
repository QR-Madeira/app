<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class SessionController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            return redirect()->route('admin.main');
        }

        return $this->view('admin.login');
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
        } else {
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
