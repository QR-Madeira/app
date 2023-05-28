<?php

namespace App\Http\Controllers;

use App\FormValidation\Core\FormValidationException;
use App\FormValidation\Socials as SocialsValidation;
use App\Models\Site;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\Factory;
use Illuminate\View\View;

use const App\Auth\P_MANAGE_SITE;

class Socials extends Controller
{
    public static function index(
        Request $r,
        string $id = null
    ): Response|View|Factory {
        if ($v = self::verify(P_MANAGE_SITE)) {
            return $v;
        }

        $s = Site::first();

        if ($id !== null) {
            $s = $s->socials->find($id);

            if ($s === null) {
                return new Response("no social with id `$id`.", 400);
            }
        }

        switch ($r->getMethod()) {
            case "GET":
                return view("admin/site_socials", [
                    "site" => $s,
                    "socials" => $s->socials()->cursorPaginate(5),
                ]);
                break;
            case "POST":
                try {
                    $s->socials()->create(SocialsValidation::verify($r));
                } catch (FormValidationException $e) {
                    return new Response((string) $e, 400);
                }

                return new Response(status: 201);
            case "PUT":
                try {
                    $s->update(SocialsValidation::verify($r));
                } catch (FormValidationException $e) {
                    return new Response((string) $e, 400);
                }

                return new Response(status: 204);
            case "DELETE":
                $s->delete();

                return new Response(status: 204);
            default:
                return new Response(status: 405);
        }
    }
}
