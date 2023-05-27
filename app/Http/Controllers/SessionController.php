<?php

namespace App\Http\Controllers;

use App\FormValidation\Core\FormValidationException;
use App\FormValidation\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class SessionController extends Controller
{
    public function index()
    {
        if (Auth::check() || Auth::viaRemember()) {
            return redirect()->route("admin.main");
        }

        return $this->view("admin.login");
    }

    public function signin(Request $request)
    {

        try {
            $in = Log::verify($request);
        } catch (FormValidationException $e) {
            return $this->error($e->getMessage());
        }

        if (Auth::attempt($in, $request->has("remember"))) {
            $request->session()->regenerate();
            return redirect()->route("admin.main");
        } else {
            return $this->error("Could not log in with those credentials!");
        }
    }

    public function signout()
    {
        Session::flush();
        Auth::logout();
        return redirect()->route("login");
    }
}
