<?php

namespace App\Http\Controllers;

use App\FormValidation\Core\FormValidationException;
use App\FormValidation\Locations;
use Illuminate\Support\Facades\Session;
use App\Models\Attraction;
use App\Models\Attractions_Close_Locations;
use Illuminate\Http\Request;

use const App\Auth\P_MANAGE_ATTRACTION;

class AttractionLocationsController extends Controller
{
    private function listLocationsById(string $id)
    {
        Session::put(static::PLACE, "admin_attr");

        return Attractions_Close_Locations::where("belonged_attraction", $id)
            ->cursorPaginate(5);
    }

    public function creator(string $id)
    {
        $v = $this->verify(P_MANAGE_ATTRACTION);
        if ($v !== null) {
            return $v;
        }

        $attr = Attraction::find($id);

        if (!$attr) {
            return $this->error("No attraction to create a close location to");
        }

        $attrLoc = $this->listLocationsById($id);

        $this->data->set("attraction", $attr);
        $this->data->set("attraction_locations", $attrLoc);
        $this->data->set("icons", self::ICONS);
        $this->data->set("phone_codes", self::PHONE_COUNTRY_CODES);
        $this->data->set("segs", ["id" => $id]);

        return $this->view("admin.create_close_location");
    }

    public function create(Request $request, string $id = null, string $id_2 = null)
    {
        $v = $this->verify(P_MANAGE_ATTRACTION);
        if ($v !== null) {
            return $v;
        }

        try {
            $in = Locations::verify($request);
        } catch (FormValidationException $e) {
            return $this->error($e->getMessage());
        }
        if (!empty($in["phone"]) || !empty($in["phone_country"])) {
            $match = preg_match(self::PHONE_REGEX, "+"
                . $in["phone_country"]
                . $in["phone"]);
            if ($match === 0 || $match === false) {
                return $this->error("Invalid phone number");
            }
        }

        $status = false;
        $method = "";

        switch ($request->method()) {
            case "POST": {
                    $in["belonged_attraction"] = $id;
                    $method = "created";
                    $status = Attractions_Close_Locations::create($in);

                    break;
                }
            case "PUT": {
                    $method = "updated";
                    $status = Attractions_Close_Locations::find($id_2)->update($in);

                    break;
                }
        }

        Session::flash("status", $status == true);
        Session::flash("message", $status == true
            ? "Location $method with success."
            : "Something went wrong.");

        return redirect()->route("admin.creator.location", ["id" => $id]);
    }

    public function updater($id, $id_2)
    {
        $v = $this->verify(P_MANAGE_ATTRACTION);
        if ($v !== null) {
            return $v;
        }

        $attr = Attraction::find($id);
        if (!$attr) {
            return $this->error("Attraction not found");
        }

        $loc = Attractions_Close_Locations::find($id_2);
        if (!$loc) {
            return $this->error("Close Location not found");
        }

        $attrLoc = $this->listLocationsById($id);

        foreach ($loc->toArray() as $k => $v) {
            $this->data->set($k, $v);
        }

        $this->data->set("attraction", $attr);
        $this->data->set("attraction_locations", $attrLoc);
        $this->data->set("icons", self::ICONS);
        $this->data->set("phone_codes", self::PHONE_COUNTRY_CODES);
        $this->data->set("segs", ["id" => $id, "id_2" => $id_2]);
        $this->data->set("isPUT", true);

        return $this->view("admin.create_close_location");
    }

    public function delete($id, $id_2)
    {
        $v = $this->verify(P_MANAGE_ATTRACTION);
        if ($v !== null) {
            return $v;
        }

        $attr = Attraction::find($id);
        if (!$attr) {
            return $this->error("Attraction not found");
        }

        $loc = Attractions_Close_Locations::find($id_2);
        if (!$loc) {
            return $this->error("Close Location not found");
        }

        Attractions_Close_Locations::destroy($id_2);
        return redirect()->route("admin.create.location", $id);
    }
}
