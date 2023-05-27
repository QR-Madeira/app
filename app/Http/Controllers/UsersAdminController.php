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
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

use const App\Auth\P_MANAGE_USER;
use const App\Auth\P_VIEW_USER;

use function App\Auth\check;
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

        if ($user->super && !Auth::user()->super) {
            return $this->error("Non super user cannot edit super user");
        }

        $this->data->set("user", $user);
        $this->data->set('permissions', getPermissionsHash());

        return $this->view("admin.edit_user");
    }

    public function pass_updater($id)
    {
        if (Auth::id() != $id) {
            return $this->error("You do not have permissions to change others password");
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
        if (check(Auth::user(), P_VIEW_USER)) {
            $collection = User::where("id", "!=", Auth::id());
            if (!Auth::user()->super) {
                $collection = $collection->where("super", "!=", 1);
            }

            $this->data->set('users', $collection->cursorPaginate(8));
            $this->data->set("canCreate", true);
        }

        $this->data->set("you", Auth::user());

        Session::put('place', 'admin_usr');


        return $this->view('admin.list_users');
    }

    public function delete($id)
    {
        $v = $this->verify(P_MANAGE_USER);
        if ($v !== null /* && (Auth::id() != $id) */) {
            return $v;
        }

        $user = User::find($id);

        if (!$user) {
            return redirect()->back();
        }

        if ($user->super && !Auth::user()->super) {
            return $this->error("Non super user cannot delete super user");
        }

        if ($user['super'] /*|| $user['id'] == Auth::id()*/) {
            Session::flash('status', false);
            Session::flash('message', "Can't delete Super Administrator.");
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
        if (Auth::id() != $id) {
            return $this->error("You do not have permissions to change others password");
        }

        try {
            $in = User_password::verify($request);
        } catch (FormValidationException $e) {
            return $this->error($e->getMessage());
        }
        $user = User::find($id);
        if (!$user) {
            return $this->error('No user found');
        }
        $hash = new PasswordHash(10, false);
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
