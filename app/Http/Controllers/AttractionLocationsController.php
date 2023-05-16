<?php

namespace App\Http\Controllers;

use App\Auth\NoPermissionsException;
use Illuminate\Support\Facades\Session;
use App\Models\Attraction;
use App\Models\Attractions_Close_Locations;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use function App\Auth\check;
use function App\Auth\checkOrThrow;

use const App\Auth\P_MANAGE_ATTRACTION;
use const App\Auth\P_VIEW_ATTRACTION;

class AttractionLocationsController extends Controller
{
    private function listLocationsById(string $id)
    {
        try {
          checkOrThrow(Auth::user(), P_VIEW_ATTRACTION);
        } catch (NoPermissionsException $e) {
          return $this->error($e->__toString());
        }

        Session::put('place', 'admin_attr');

        $attrList = Attractions_Close_Locations::where("belonged_attraction", $id)->get();

        return $attrList;
    }

    public function creator(Request $request, string $id)
    {
        try {
          checkOrThrow(Auth::user(), P_MANAGE_ATTRACTION);
        } catch (NoPermissionsException $e) {
          return $this->error($e->__toString());
        }

        $attr = Attraction::find($id);

        if (!$attr) { // No attraction to create a close location to
            return redirect()->back();
        }

        $attrLoc = $this->listLocationsById($id);

        $status = $request->session()->get('status');
        $route = $request->session()->get('route');

        $this->data->set('created', $status);
        $this->data->set('route', $route);
        $this->data->set('attraction', $attr);
        $this->data->set('attraction_locations', $attrLoc);
        $this->data->set('arr', ['id' => $id]);

        return $this->view('admin.create_close_location');
    }

    public function create(Request $request, string $id, string $id_2 = null)
    {
        try {
          checkOrThrow(Auth::user(), P_MANAGE_ATTRACTION);
        } catch (NoPermissionsException $e) {
          return $this->error($e->__toString());
        }

        $in = $request->validate([
            'icon' => 'required|filled|present|string',
            'name' => 'required|filled|present|string|max:80|min:3',
            'location' => 'required|filled|present|string|max:80|min:3',
            'phone' => 'nullable',
        ]);

        if (!empty($phone = $in["phone"])) {
            $phone_regex = '\+(9[976]\d|8[987530]\d|6[987]\d|5[90]\d|42\d|3[875]\d|2[98654321]\d|9[8543210]|8[6421]|6[6543210]|5[87654321]|4[987654310]|3[9643210]|2[70]|7|1)\d{1,14}$';

            $matches = [];
            $match = preg_match($phone_regex, $phone, $matches);
            if ($match === 0) { // no match
            }
            if ($match === false) { // error
            }

            dd($match, $matches);
        }

        $location = [
            'icon_path' => $in['icon'],
            'name' => $in['name'],
            'location' => $in['location'],
            'phone' => $in['phone'],
        ];

        $status = false;
        $method = "";

        switch ($request->method()) {
            case 'POST': {
                    $location['belonged_attraction'] = $id;
                    $method = "created";
                    $status = Attractions_Close_Locations::create($location);

                    break;
                }
            case "PUT": {
                    $loc = Attractions_Close_Locations::find($id_2);
                    $method = "updated";
                    $status = $loc->update($location);

                    break;
                }
        }

        Session::flash('status', $status == true);
        Session::flash('message', $status == true ? "Location $method with success." : "Something went wrong.");

        return redirect()->route('admin.creator.location', ['id' => $id]);
    }

    public function updater($id, $id_2)
    {
        if (!check(Auth::user(), P_MANAGE_ATTRACTION)) {
            return redirect()->back();
        }

        $attr = Attraction::find($id);
        $loc = Attractions_Close_Locations::find($id_2);


        if (!$loc || !$attr) {
            return redirect()->back();
        }

        $attrLoc = $this->listLocationsById($id);

        foreach ([
                "id" => $id_2,
                "icon_path" => $loc->icon_path,
                "name" => $loc->name,
                "location" => $loc->location,
                "phone" => $loc->phone,
            ] as $k => $v) {
            $this->data->set($k, $v);
        }

        $this->data->set('attraction', $attr);
        $this->data->set('attraction_locations', $attrLoc);
        $arr = ['id' => $id, 'id_2' => $id_2];
        $this->data->set('arr', $arr);
        $this->data->set('isPUT', true);

        return $this->view('admin.create_close_location');
    }

    public function delete($id, $id_2)
    {
        if (!check(Auth::user(), P_MANAGE_ATTRACTION)) {
            return redirect()->back();
        }

        $attr = Attraction::find($id);

        $loc = Attractions_Close_Locations::find($id_2);

        if (!$loc || !$attr) {
            return redirect()->back();
        }

        Attractions_Close_Locations::destroy($id_2);
        return redirect()->route('admin.create.location', $id);
    }
}
