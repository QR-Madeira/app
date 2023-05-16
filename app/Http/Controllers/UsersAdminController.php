<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

use function App\Auth\check;

use const App\Auth\P_MANAGE_USER;
use const App\Auth\P_VIEW_USER;

use function App\Auth\getPermissionsHash;
use function App\Auth\grant;

class UsersAdminController extends Controller
{
    public function creator(Request $request)
    {
        if (!check(Auth::user(), P_MANAGE_USER)) {
            return redirect()->back();
        }

        Session::put('place', 'admin_usr');

        $status = $request->session()->get('status');
        $message = $request->session()->get('message');

        $this->data->set('status', $status);
        $this->data->set('message', $message);
        $this->data->set('permissions', getPermissionsHash());

        return $this->view('admin.create_user');
    }

    public function list()
    {
        if (!check(Auth::user(), P_VIEW_USER)) {
            return redirect()->back();
        }

        Session::put('place', 'admin_usr');

        $all_users = User::all();

        $this->data->set('users', $all_users);

        return $this->view('admin.list_users');
    }

    public function delete($id)
    {
        if (!check(Auth::user(), P_MANAGE_USER)) {
            return redirect()->back();
        }

        $user = User::find($id);

        if (!$user) {
            return redirect()->back();
        }

        User::destroy($id);
        return redirect()->route('admin.list.users');
    }

    public function create(Request $request)
    {
        if (!check(Auth::user(), P_MANAGE_USER)) {
            return redirect()->back();
        }

        $validatedData = $request->validate([
            'name' => 'required|min:4',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:4|confirmed',
        ]);

        $pass_hash = Hash::make($validatedData['password']);

        $user = new User();
        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];
        $user->password = $pass_hash;
        grant($user, ...$request->post("permissions"));

        if ($user->save()) {
            $request->session()->flash('status', true);
            $request->session()->flash('message', 'User created with success!');
            return redirect()->route('admin.creator.user');
        } else {
            $request->session()->flash('status', false);
            $request->session()->flash('message', 'Something went wrong when creating the player, try again!');
            return redirect()->route('admin.creator.user');
        }
    }
}
