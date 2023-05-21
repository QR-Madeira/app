<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;

class AdminController extends Controller
{
    public function main()
    {
        Session::put('place', 'main');
        return $this->view('admin.main');
    }
}
