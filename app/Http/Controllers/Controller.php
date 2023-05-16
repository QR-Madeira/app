<?php

namespace App\Http\Controllers;

use App\Auth\NoPermissionsException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use App\Classes\Data;
use Illuminate\Http\RedirectResponse;

use function App\Auth\checkOrThrow;

class Controller extends BaseController
{
    use AuthorizesRequests;
    use ValidatesRequests;

    protected const PLACE = "place";
    protected const ICONS = [
        "other_houses",
        "local_hospital",
        "shopping_cart",
        "account_balance",
        "hotel",
    ];
    protected const PHONE_REGEX = '/\+(9[976]\d|8[987530]\d|6[987]\d|5[90]\d|42\d|3[875]\d|2[98654321]\d|9[8543210]|8[6421]|6[6543210]|5[87654321]|4[987654310]|3[9643210]|2[70]|7|1)\d{1,14}$/';

    protected Data $data;

    protected function view($view)
    {
        $this->data->set('isLogged', Auth::check());

        $this->data->set('userName', Auth::check() ? Auth::user()->name : null);

        return view($view, $this->data->get());
    }

    public function __construct()
    {
        $this->data = Data::getInstance();
    }

    protected function error(string $error): RedirectResponse
    {
        session()->flash('error', $error);
        return redirect()->back();
    }

    protected function verify(int $permission): ?RedirectResponse
    {
        try {
            checkOrThrow(Auth::user(), $permission);
        } catch (NoPermissionsException $e) {
            return $this->error($e);
        }

        return null;
    }
}
