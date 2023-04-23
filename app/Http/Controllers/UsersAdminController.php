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
        $validatedData = $request->validate([
            'name' => 'required|min:4',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:4|confirmed'
          ]);

          $pass_hash = password_hash($validatedData['password'], PASSWORD_BCRYPT);

          $users = [
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => $pass_hash
          ];

          $status = Users::create($users);

          $request->session()->flash('status', true);
          $request->session()->flash('route', route('view', ['title_compiled' => $this->compileTitle($validatedData['title'])]));
          return redirect()->route('admin.creator_user');

          return $status;
    }
}
