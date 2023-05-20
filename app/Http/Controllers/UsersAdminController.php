<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\FormValidation\Core\FormValidationException;
use App\FormValidation\Users as UsersValidation;
use App\Mail\Core\EmailCreator;
use App\Mail\Core\Mailer;
use App\Mail\UserCreation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

use const App\Auth\P_MANAGE_USER;
use const App\Auth\P_VIEW_USER;

use function App\Auth\getPermissionsHash;

class UsersAdminController extends Controller
{
    public function updater($id)
    {
        $v = $this->verify(P_MANAGE_USER);
        if ($v !== null) {
            return $v;
        }

        Session::put('place', 'admin_usr');

        $user = User::find($id);
        if (!$user) {
            return $this->error("User not found");
        }

        $this->data->set("user", $user);
        $this->data->set('permissions', getPermissionsHash());

        return $this->view("admin.edit_user");
    }

    public function creator(Request $request)
    {
        $v = $this->verify(P_MANAGE_USER);
        if ($v !== null) {
            return $v;
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
        $v = $this->verify(P_VIEW_USER);
        if ($v !== null) {
            return $v;
        }

        Session::put('place', 'admin_usr');

        $all_users = User::cursorPaginate(8);

        $this->data->set('users', $all_users);

        return $this->view('admin.list_users');
    }

    public function delete($id)
    {
        $v = $this->verify(P_MANAGE_USER);
        if ($v !== null) {
            return $v;
        }

        $user = User::find($id);

        if (!$user) {
            return redirect()->back();
        }

        User::destroy($id);
        return redirect()->route('admin.list.users');
    }

    public function create(Request $request, string $id = null)
    {
        $v = $this->verify(P_MANAGE_USER);
        if ($v !== null) {
            return $v;
        }

        try {
            $in = UsersValidation::verify($request);
        } catch (FormValidationException $e) {
            return $this->error($e->getMessage());
        }
        $status = false;
        $method = "";

        switch ($request->method()) {
            case "POST":
                $method = "created";
                $u = User::create($in);

                Mailer::send(new UserCreation($u));

                break;
            case "PUT":
                $method = "updated";
                $user = User::find($id);
                if ($user) {
                    return $status = false;
                }
                if (!$in['old_password'] && !$in['password']) {
                    $status = $user->update($in);
                } else {
                    $attempt = Auth::attempt(['email' => $user['email'], 'password' => $in['old_password']]);
                    if (!$attempt) {
                        return $status = false;
                    }
                    $status = $user->update($in);
                }

                break;
        }

        Session::flash("status", $status == true);
        Session::flash("message", $status == true
            ? "User $method with success."
            : "Something went wrong.");

        return redirect()->route("admin.list.users");
    }
}
