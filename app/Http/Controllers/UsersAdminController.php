<?php

namespace App\Http\Controllers;

use App\Models\Users;
use Illuminate\Http\Request;

class UsersAdminController extends Controller
{
    public function creator()
    {
        return view('admin.create_user');
    }

    public function list()
    {
        $all_users = Users::all();
        
        $data = array(
            'users' => $all_users
        );

        return view('admin.list_users', $data);
    }

    public function create(Request $request)
    {
        return view('admin.create_user');
    }
}
