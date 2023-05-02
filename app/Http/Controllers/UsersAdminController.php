<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class UsersAdminController extends Controller
{
    public function creator()
    {
        Session::put('place', 'admin_usr');

        //$status = $request->session()->get('status');
        //$this->data->set('created', $status);
        return $this->view('admin.create_user');
    }

    public function list()
    {
        Session::put('place', 'admin_usr');

        $all_users = User::all();
        
        $this->data->set('users', $all_users);

        return $this->view('admin.list_users');
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
            return redirect()->route('admin.creator_user');
        }else{
            $request->session()->flash('status', false);
            return redirect()->route('admin.creator_user');
        }
    }
}
