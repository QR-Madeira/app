<?php

namespace App\Http\Controllers;

use App\Classes\PasswordHash;
use App\Models\User;
use App\FormValidation\Core\FormValidationException;
use App\FormValidation\User_password;
use App\FormValidation\Users as UsersValidation;
use App\Mail\Core\Mailer;
use App\Mail\UserCreation;
use App\Models\Attraction;
use Illuminate\Http\Request;
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

    public function pass_updater($id)
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

        return $this->view("admin.edit_pass_user");
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

        $all_users = User::where('active', 1)->cursorPaginate(8);

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

        if ($user['super'] == 1 /*|| $user['id'] == Auth::id()*/) {
            Session::flash('status', false);
            Session::flash('message', "Can't delete Super Administrator or Your Own Self.");
            return redirect()->back();
        }

        $attractions = Attraction::where('created_by', $user['id'])->get()->toArray();
        $ls = "";
        if ($attractions != null) {
            Session::flash('status', false);
            foreach ($attractions as $attr) {
                $ls .= "\"" . $attr['title'] . "\"; ";
            }
            Session::flash('message', "There are attractions attached to this user, such as: " . $ls);
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

        $u = false;

        switch ($request->method()) {
            case "POST":
                $in["password"] = "";
                $u = User::create($in);

                Mailer::send(new UserCreation($u));

                if (!$u) {
                    Session::flash("status", (bool) $u);
                    $this->error("Something went wrong.");
                }

                Session::flash(
                    "message",
                    "A e-mail was sent to `$in[email]` to activate the account and set their password."
                );

                break;
            case "PUT":
                $u = User::find($id)->update($in);

                if (!$u) {
                    Session::flash("status", (bool) $u);
                    $this->error("Something went wrong.");
                }

                Session::flash("message", "User updated with success.");

                break;
        }

        Session::flash("status", (bool) $u);

        return redirect()->route("admin.list.users");
    }

    public function update_pass(Request $request, string $id = null)
    {
        $v = $this->verify(P_MANAGE_USER);
        if ($v !== null) {
            return $v;
        }

        try {
            $in = User_password::verify($request);
        } catch (FormValidationException $e) {
            return $this->error($e->getMessage());
        }
        $user = User::find($id);
        if (!$user) {
            return $this->error('No');
        }
        //$attempt = Auth::attempt(['email' => $user['email'], 'password' => $in['old_password']]);
        $hash = new PasswordHash(8, false);
        if (!$hash->CheckPassword($in['old_password'], $user['password'])) {
            return $this->error('ABBA');
        }
        $status = $user->update(['password' => $in['password']]);

        Session::flash("status", $status == true);
        Session::flash("message", $status == true
            ? "Password changed with success." : "Something went wrong.");

        return redirect()->route("admin.list.users");
    }
}
