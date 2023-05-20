<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function main()
    {
        Session::put('place', 'main');
        return $this->view('admin.main');
    }
}
