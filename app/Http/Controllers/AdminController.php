<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {   
        $this->set_default();
        return view('admin.admin_page', $this->data);
    }
}
