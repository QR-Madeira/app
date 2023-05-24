<?php

namespace App\Http\Controllers;

use App\Auth\NoPermissionsException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use App\Classes\Data;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\App;
use TorresDeveloper\HTTPMessage\URI;
use TorresDeveloper\Polyglot\Lang;
use TorresDeveloper\Polyglot\Translator;

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
        "atm",
        "hotel",
        "school",
        "local_gas_station",
        "fitness_center",
        "local_cafe",
        "local_dining",
        "local_bar",
        "park",
        "fort",
        "handyman",
        "sports_esports",
        "sports_basketball",
        "surfing",
    ];
    protected const PHONE_REGEX = '/\+(9[976]\d|8[987530]\d|6[987]\d|5[90]\d|42\d|3[875]\d|2[98654321]\d|9[8543210]|8[6421]|6[6543210]|5[87654321]|4[987654310]|3[9643210]|2[70]|7|1)\d{1,14}$/';
    protected const PHONE_COUNTRY_CODES = [
        93 => '&#x1F1E6&#x1F1EB',
        355 => '&#x1F1E6&#x1F1FD',
        213 => '&#x1F1E9&#x1F1FF',
        376 => '&#x1F1E6&#x1F1E9',
        244 => '&#x1F1E6&#x1F1F4',
        1264 => '&#x1F1E6&#x1F1EE',
        1268 => '&#x1F1E6&#x1F1EC',
        54 => '&#x1F1E6&#x1F1F7',
        374 => '&#x1F1E6&#x1F1F2',
        297 => '&#x1F1E6&#x1F1FC',
        247 => '&#x1F1E6&#x1F1E8',
        61 => '&#x1F1E6&#x1F1FA',
        43 => '&#x1F1E6&#x1F1F9',
        994 => '&#x1F1E6&#x1F1FF',
        1242 => '&#x1F1E7&#x1F1F8',
        973 => '&#x1F1E7&#x1F1ED',
        880 => '&#x1F1E7&#x1F1E9',
        1246 => '&#x1F1E7&#x1F1E7',
        375 => '&#x1F1E7&#x1F1FE',
        32 => '&#x1F1E7&#x1F1EA',
        501 => '&#x1F1E7&#x1F1FF',
        229 => '&#x1F1E7&#x1F1EF',
        1441 => '&#x1F1E7&#x1F1F2',
        975 => '&#x1F1E7&#x1F1F9',
        591 => '&#x1F1E7&#x1F1F4',
        599 => '&#x1F1E7&#x1F1F6',
        387 => '&#x1F1E7&#x1F1E6',
        267 => '&#x1F1E7&#x1F1FC',
        55 => '&#x1F1E7&#x1F1F7',
        246 => '&#x1F1EE&#x1F1F4',
        673 => '&#x1F1E7&#x1F1F3',
        359 => '&#x1F1E7&#x1F1EC',
        226 => '&#x1F1E7&#x1F1EB',
        257 => '&#x1F1E7&#x1F1EE',
        855 => '&#x1F1F0&#x1F1ED',
        237 => '&#x1F1E8&#x1F1F2',
        1 => '&#x1F1E8&#x1F1E6',
        238 => '&#x1F1E8&#x1F1FB',
        1345 => '&#x1F1F0&#x1F1FE',
        236 => '&#x1F1E8&#x1F1EB',
        235 => '&#x1F1F9&#x1F1E9',
        56 => '&#x1F1E8&#x1F1F1',
        86 => '&#x1F1E8&#x1F1F3',
        57 => '&#x1F1E8&#x1F1F4',
        269 => '&#x1F1F0&#x1F1F2',
        242 => '&#x1F1E8&#x1F1EC',
        243 => '&#x1F1E8&#x1F1E9',
        682 => '&#x1F1E8&#x1F1F0',
        506 => '&#x1F1E8&#x1F1F7',
        385 => '&#x1F1ED&#x1F1F7',
        53 => '&#x1F1E8&#x1F1FA',
        5999 => '&#x1F1E8&#x1F1FC',
        357 => '&#x1F1E8&#x1F1FE',
        420 => '&#x1F1E8&#x1F1FF',
        45 => '&#x1F1E9&#x1F1F0',
        253 => '&#x1F1E9&#x1F1EF',
        1767 => '&#x1F1E9&#x1F1F2',
        1809 => '&#x1F1E9&#x1F1F4',
        670 => '&#x1F1F9&#x1F1F1',
        593 => '&#x1F1EA&#x1F1E8',
        20 => '&#x1F1EA&#x1F1EC',
        503 => '&#x1F1F8&#x1F1FB',
        240 => '&#x1F1EC&#x1F1F6',
        291 => '&#x1F1EA&#x1F1F7',
        372 => '&#x1F1EA&#x1F1EA',
        268 => '&#x1F1F8&#x1F1FF',
        251 => '&#x1F1EA&#x1F1F9',
        500 => '&#x1F1EB&#x1F1F0',
        298 => '&#x1F1EB&#x1F1F4',
        679 => '&#x1F1EB&#x1F1EF',
        358 => '&#x1F1EB&#x1F1EE',
        33 => '&#x1F1EB&#x1F1F7',
        594 => '&#x1F1EC&#x1F1EB',
        689 => '&#x1F1F5&#x1F1EB',
        241 => '&#x1F1EC&#x1F1E6',
        220 => '&#x1F1EC&#x1F1F2',
        995 => '&#x1F1EC&#x1F1EA',
        49 => '&#x1F1E9&#x1F1EA',
        233 => '&#x1F1EC&#x1F1ED',
        350 => '&#x1F1EC&#x1F1EE',
        30 => '&#x1F1EC&#x1F1F7',
        299 => '&#x1F1EC&#x1F1F1',
        1473 => '&#x1F1EC&#x1F1E9',
        590 => '&#x1F1EC&#x1F1F5',
        1671 => '&#x1F1EC&#x1F1FA',
        502 => '&#x1F1EC&#x1F1F9',
        224 => '&#x1F1EC&#x1F1F3',
        245 => '&#x1F1EC&#x1F1FC',
        592 => '&#x1F1EC&#x1F1FE',
        509 => '&#x1F1ED&#x1F1F9',
        504 => '&#x1F1ED&#x1F1F3',
        852 => '&#x1F1ED&#x1F1F0',
        36 => '&#x1F1ED&#x1F1FA',
        354 => '&#x1F1EE&#x1F1F8',
        91 => '&#x1F1EE&#x1F1F3',
        62 => '&#x1F1EE&#x1F1E9',
        98 => '&#x1F1EE&#x1F1F7',
        964 => '&#x1F1EE&#x1F1F6',
        353 => '&#x1F1EE&#x1F1EA',
        972 => '&#x1F1EE&#x1F1F1',
        39 => '&#x1F1EE&#x1F1F9',
        225 => '&#x1F1E8&#x1F1EE',
        1876 => '&#x1F1EF&#x1F1F2',
        81 => '&#x1F1EF&#x1F1F5',
        962 => '&#x1F1EF&#x1F1F4',
        7 => '&#x1F1F0&#x1F1FF',
        254 => '&#x1F1F0&#x1F1EA',
        686 => '&#x1F1F0&#x1F1EE',
        850 => '&#x1F1F0&#x1F1F5',
        82 => '&#x1F1F0&#x1F1F7',
        383 => '&#x1F1FD&#x1F1F0',
        965 => '&#x1F1F0&#x1F1FC',
        996 => '&#x1F1F0&#x1F1EC',
        856 => '&#x1F1F1&#x1F1E6',
        371 => '&#x1F1F1&#x1F1FB',
        961 => '&#x1F1F1&#x1F1E7',
        266 => '&#x1F1F1&#x1F1F8',
        231 => '&#x1F1F1&#x1F1F7',
        218 => '&#x1F1F1&#x1F1FE',
        423 => '&#x1F1F1&#x1F1EE',
        370 => '&#x1F1F1&#x1F1F9',
        352 => '&#x1F1F1&#x1F1FA',
        853 => '&#x1F1F2&#x1F1F4',
        389 => '&#x1F1F2&#x1F1F0',
        261 => '&#x1F1F2&#x1F1EC',
        265 => '&#x1F1F2&#x1F1FC',
        60 => '&#x1F1F2&#x1F1FE',
        960 => '&#x1F1F2&#x1F1FB',
        223 => '&#x1F1F2&#x1F1F1',
        356 => '&#x1F1F2&#x1F1F9',
        692 => '&#x1F1F2&#x1F1ED',
        596 => '&#x1F1F2&#x1F1F6',
        222 => '&#x1F1F2&#x1F1F7',
        230 => '&#x1F1F2&#x1F1FA',
        262 => '&#x1F1FE&#x1F1F9',
        52 => '&#x1F1F2&#x1F1FD',
        691 => '&#x1F1EB&#x1F1F2',
        373 => '&#x1F1F2&#x1F1E9',
        377 => '&#x1F1F2&#x1F1E8',
        976 => '&#x1F1F2&#x1F1F3',
        382 => '&#x1F1F2&#x1F1EA',
        1664 => '&#x1F1F2&#x1F1F8',
        212 => '&#x1F1F2&#x1F1E6',
        258 => '&#x1F1F2&#x1F1FF',
        95 => '&#x1F1F2&#x1F1F2',
        264 => '&#x1F1F3&#x1F1E6',
        674 => '&#x1F1F3&#x1F1F7',
        977 => '&#x1F1F3&#x1F1F5',
        31 => '&#x1F1F3&#x1F1F1',
        687 => '&#x1F1F3&#x1F1E8',
        64 => '&#x1F1F3&#x1F1FF',
        505 => '&#x1F1F3&#x1F1EE',
        227 => '&#x1F1F3&#x1F1EA',
        234 => '&#x1F1F3&#x1F1EC',
        683 => '&#x1F1F3&#x1F1FA',
        672 => '&#x1F1F3&#x1F1EB',
        1670 => '&#x1F1F2&#x1F1F5',
        47 => '&#x1F1F3&#x1F1F4',
        968 => '&#x1F1F4&#x1F1F2',
        92 => '&#x1F1F5&#x1F1F0',
        680 => '&#x1F1F5&#x1F1FC',
        970 => '&#x1F1F5&#x1F1F8',
        507 => '&#x1F1F5&#x1F1E6',
        675 => '&#x1F1F5&#x1F1EC',
        595 => '&#x1F1F5&#x1F1FE',
        51 => '&#x1F1F5&#x1F1EA',
        63 => '&#x1F1F5&#x1F1ED',
        48 => '&#x1F1F5&#x1F1F1',
        351 => '&#x1F1F5&#x1F1F9',
        1787 => '&#x1F1F5&#x1F1F7',
        974 => '&#x1F1F6&#x1F1E6',
        262 => '&#x1F1F7&#x1F1EA',
        40 => '&#x1F1F7&#x1F1F4',
        7 => '&#x1F1F7&#x1F1FA',
        250 => '&#x1F1F7&#x1F1FC',
        685 => '&#x1F1FC&#x1F1F8',
        378 => '&#x1F1F8&#x1F1F2',
        239 => '&#x1F1F8&#x1F1F9',
        966 => '&#x1F1F8&#x1F1E6',
        221 => '&#x1F1F8&#x1F1F3',
        381 => '&#x1F1F7&#x1F1F8',
        248 => '&#x1F1F8&#x1F1E8',
        232 => '&#x1F1F8&#x1F1F1',
        65 => '&#x1F1F8&#x1F1EC',
        421 => '&#x1F1F8&#x1F1F0',
        386 => '&#x1F1F8&#x1F1EE',
        677 => '&#x1F1F8&#x1F1E7',
        252 => '&#x1F1F8&#x1F1F4',
        27 => '&#x1F1FF&#x1F1E6',
        211 => '&#x1F1F8&#x1F1F8',
        34 => '&#x1F1EA&#x1F1F8',
        94 => '&#x1F1F1&#x1F1F0',
        290 => '&#x1F1F8&#x1F1ED',
        1869 => '&#x1F1F0&#x1F1F3',
        1758 => '&#x1F1F1&#x1F1E8',
        508 => '&#x1F1F5&#x1F1F2',
        249 => '&#x1F1F8&#x1F1E9',
        597 => '&#x1F1F8&#x1F1F7',
        46 => '&#x1F1F8&#x1F1EA',
        41 => '&#x1F1E8&#x1F1ED',
        963 => '&#x1F1F8&#x1F1FE',
        886 => '&#x1F1F9&#x1F1FC',
        992 => '&#x1F1F9&#x1F1EF',
        255 => '&#x1F1F9&#x1F1FF',
        66 => '&#x1F1F9&#x1F1ED',
        228 => '&#x1F1F9&#x1F1EC',
        690 => '&#x1F1F9&#x1F1F0',
        676 => '&#x1F1F9&#x1F1F4',
        1868 => '&#x1F1F9&#x1F1F9',
        216 => '&#x1F1F9&#x1F1F3',
        90 => '&#x1F1F9&#x1F1F7',
        993 => '&#x1F1F9&#x1F1F2',
        1649 => '&#x1F1F9&#x1F1E8',
        688 => '&#x1F1F9&#x1F1FB',
        256 => '&#x1F1FA&#x1F1EC',
        380 => '&#x1F1FA&#x1F1E6',
        971 => '&#x1F1E6&#x1F1EA',
        44 => '&#x1F1EC&#x1F1E7',
        1 => '&#x1F1FA&#x1F1F8',
        598 => '&#x1F1FA&#x1F1FE',
        998 => '&#x1F1FA&#x1F1FF',
        678 => '&#x1F1FB&#x1F1FA',
        39 => '&#x1F1FB&#x1F1E6',
        58 => '&#x1F1FB&#x1F1EA',
        84 => '&#x1F1FB&#x1F1F3',
        1284 => '&#x1F1FB&#x1F1EC',
        1340 => '&#x1F1FB&#x1F1EE',
        681 => '&#x1F1FC&#x1F1EB',
        967 => '&#x1F1EA&#x1F1ED',
        967 => '&#x1F1FE&#x1F1EA',
        260 => '&#x1F1FF&#x1F1F2',
        263 => '&#x1F1FF&#x1F1FC',
    ];

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

    protected static function error(string $error): RedirectResponse
    {
        session()->flash('error', $error);
        return redirect()->back();
    }

    protected function verify(int $permission): ?RedirectResponse
    {
        try {
            checkOrThrow(Auth::user(), $permission);
        } catch (NoPermissionsException $e) {
            return $this->error($e->getMessage());
        }

        return null;
    }

    protected function translate(string $txt): string
    {
        try {
            if (env("LIBRETRANSLATE_TRANSLATE", false) != true) {
                throw new \Exception("Won't translate");
            }

            $t = new Translator(new URI(env("LIBRETRANSLATE_URI")));

            $from = $t->detectLang($txt);

            if ($from->getCode() !== ($to = App::currentLocale())) {
                return $t->translate($txt, new Lang($to), $from);
            }
        } catch (\Throwable) {
            return $txt;
        }

        return $txt;
    }
}
