<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use App\Models\Attraction;
use App\Models\Attractions_Close_Locations;
use Illuminate\Http\Request;

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

        Session::put('place', 'admin_attr');

        $attrLoc = $this->listLocationsById($id);

        $status = $request->session()->get('status');
        $route = $request->session()->get('route');

        $this->data->set('created', $status);
        $this->data->set('route', $route);
        $this->data->set('attraction', $attr);
        $this->data->set('attraction_locations', $attrLoc);

        return $this->view('admin.create_close_location');
    }

    public function create(Request $request, $id)
    {
        $validatedData = $request->validate([
            'icon' => 'required',
            'name' => 'required',
            'location' => 'required',
            'phone' => 'nullable|numeric'
        ]);

        $location = [
            'belonged_attraction' => $id,
            'icon_path' => $validatedData['icon'],
            'name' => $validatedData['name'],
            'location' => $validatedData['location'],
            'phone' => $validatedData['phone'],
        ];

        $status = Attractions_Close_Locations::create($location);

        if ($status) {
            Session::flash('status', true);
            Session::flash('message', 'Location created with success.');
            return redirect()->route('admin.creator_location', ['id' => $id]);
        } else {
            Session::flash('status', false);
            Session::flash('message', 'Something went wrong with the creation');
            return redirect()->route('admin.creator_location', ['id' => $id]);
        }
    }

    public function delete($id)
    {
        $loc = Attractions_Close_Locations::find($id);

        if (!$loc || !$id) {
            throw new \RuntimeException("Location not found");
        }

        Attractions_Close_Locations::destroy($id);
        return redirect()->back();
    }
}
