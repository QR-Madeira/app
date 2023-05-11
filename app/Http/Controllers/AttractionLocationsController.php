<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use App\Models\Attraction;
use App\Models\Attractions_Close_Locations;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use function App\Auth\check;

use const App\Auth\P_MANAGE_ATTRACTION;

class AttractionLocationsController extends Controller
{
    public function listLocationsById($id)
    {

        Session::put('place', 'admin_attr');

        $attrList = Attractions_Close_Locations::where("belonged_attraction", $id)->get();

        return $attrList;
    }

    public function creator(Request $request, $id)
    {
        $attr = Attraction::find($id);

        if (!$attr || !$id) {
            throw new \RuntimeException("no attraction found");
        }

        $attrLoc = $this->listLocationsById($id);

        $status = $request->session()->get('status');
        $route = $request->session()->get('route');

        $this->data->set('created', $status);
        $this->data->set('route', $route);
        $this->data->set('attraction', $attr);
        $this->data->set('attraction_locations', $attrLoc);
        $arr = ['id' => $id];
        $this->data->set('arr', $arr);

        return $this->view('admin.create_close_location');
    }

    public function create(Request $request, $id, $id_2 = null)
    {

        $validatedData = $request->validate([
            'icon' => 'required',
            'name' => 'required',
            'location' => 'required',
            'phone' => 'nullable|numeric'
        ]);

        $location = [
            'icon_path' => $validatedData['icon'],
            'name' => $validatedData['name'],
            'location' => $validatedData['location'],
            'phone' => $validatedData['phone'],
        ];

        $status = false;
        $method = "";

        switch($request->method()){
            case 'POST': {
                $location['belonged_attraction'] = $id;
                $method = "created";
                $status = Attractions_Close_Locations::create($location);

                break;
            }
            case "PUT":{
                $loc = Attractions_Close_Locations::find($id_2);
                $method = "updated";
                $status = $loc->update($location);

                break;
            }
        }
        Session::flash('status', $status == true);
        Session::flash('message', $status == true? "Location $method with success." : "Something went wrong.");
        return redirect()->route('admin.creator.location', ['id' => $id]);
    }

    public function updater($id, $id_2)
    {

        if(!check(Auth::user(), P_MANAGE_ATTRACTION))
            return redirect()->back();

        $attr = Attraction::find($id);
        $loc = Attractions_Close_Locations::find($id_2);


        if (!$loc || !$id || !$attr) {
            throw new \RuntimeException("no location found");
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
        $attr = Attraction::find($id);  

        $loc = Attractions_Close_Locations::find($id_2);

        if (!$loc || !$attr) {
            throw new \RuntimeException("Location not found");
        }

        Attractions_Close_Locations::destroy($id_2);
        return redirect()->route('admin.create.location', $id);
    }
}
