<?php

namespace App\Http\Controllers;

use App\FormValidation\Core\FormValidationException;
use App\FormValidation\Verification as FormValidation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class Verification extends Controller
{
    public static function index(Request $r)
    {
        switch ($r->getMethod()) {
            case "GET":
                $email = $r->get("email");

                return view("viewer/verify", ["email" => $email]);

            case "POST":
                try {
                    $in = FormValidation::verify($r);
                } catch (FormValidationException $e) {
                    return self::error($e->getMessage());
                }

                $u = User::where("email", $in["email"])->first();

                if ($u === null) {
                    return self::error("no user found");
                }

                if ($u->verification_code !== $in["code"]) {
                    return self::error("wrong code");
                }

                $u->verification_code = null;
                $u->active = true;
                $u->password = $in["password"];
                $u->save();

                return redirect("login");
            default:
                return (new Response())->setStatusCode(405);
        }
    }
}
