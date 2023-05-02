<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class UsersAdminController extends Controller
{
    public function creator(Request $request)
    {
        Session::put('place', 'admin_usr');

        $this->set_default();

        $status = $request->session()->get('status');
        $message = $request->session()->get('message');

        $this->set_data('status', $status);
        $this->set_data('message', $message);

        return view('admin.create_user', $this->data);
    }

    public function list()
    {

        Session::put('place', 'admin_usr');
        
        $this->set_default();

        $all_users = User::all();
        
        $this->set_data('users', $all_users);

        return view('admin.list_users', $this->data);
    }

    public function delete($id)
    {
        User::destroy($id);
        return redirect()->route('admin.list_users');
    }

    public function create(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|min:4',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:4|confirmed',
            'user_type'=> 'required'
        ]);

        $pass_hash = Hash::make($validatedData['password']);

        $users = [
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => $pass_hash
        ];

        $status = User::create($users);

        if($status){
            $request->session()->flash('status', true);
            $request->session()->flash('message', 'User created with success!');
            return redirect()->route('admin.creator_user');
        }else{
            $request->session()->flash('status', false);
            $request->session()->flash('message', 'Something went wrong when creating the player, try again!');
            return redirect()->route('admin.creator_user');
        }
    }
}
