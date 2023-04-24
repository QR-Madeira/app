<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use App\Models\Users;
use Illuminate\Http\Request;

class UsersAdminController extends Controller
{
    public function creator(Request $request)
    {
        $this->set_default();
        $status = $request->session()->get('status');
        $this->set_data('created', $status);
        return view('admin.create_user', $this->data);
    }

    public function list()
    {
        $this->set_default();

        $all_users = Users::all();
        
        $this->set_data('users', $all_users);

        return view('admin.list_users', $this->data);
    }

    public function delete($id)
    {
        Users::destroy($id);
        return redirect()->route('admin.list_users');
    }

    public function create(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|min:4',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:4|confirmed'
          ]);

          $pass_hash = Hash::make($validatedData['password']);

          $users = [
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => $pass_hash
          ];

          $status = Users::create($users);

          $request->session()->flash('status', true);
          return redirect()->route('admin.creator_user');

          return $status;
    }
}
