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
            return redirect()->route('admin.list.attraction');
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
            Session::put('place', 'admin_attr');
            return redirect()->route('admin.list');
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
