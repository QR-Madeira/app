<?php

namespace App\Http\Controllers;

use App\Models\Attraction;
use App\Models\Attractions_Pictures;
use App\Models\Attractions_Close_Locations;

class AttractionsViewerController extends Controller
{
    public function index($title_compiled)
    {
        $a = Attraction::where('title_compiled', '=', $title_compiled)
            ->first()
            ?->toArray();

        if ($a == null) {
            return $this->error('Attraction not found');
        }

        foreach (
            [
            "image" => "storage/attractions/$a[image]",
            "title_compiled" => $title_compiled,
            "title" => $a["title"],
            "description" => nl2br($this->translate($a["description"])),
            "qr" => asset("storage/qr-codes/$a[qr_code_path]"),
            "lat" => $a["lat"],
            "lon" => $a["lon"],
            ] as $k => $v
        ) {
            $this->data->set($k, $v);
        }

        return $this->view('viewer.get');
    }

    public function gallery($title_compiled)
    {
        $attraction = Attraction::where('title_compiled', '=', $title_compiled)->first();
        if ($attraction == null) {
            return $this->error('Attraction not found');
        }
        $attraction = $attraction->toArray();

        $images = Attractions_Pictures::where('belonged_attraction', '=', $attraction['id'])->get();
        if ($images == null) {
            return $this->error('Gallery not found');
        }
        $images = $images->toArray();

        for ($i = 0; $i < count($images); $i++) {
            $images[$i]['image_path'] = '/storage/gallery/' . $images[$i]['image_path'];
        }

        $this->data->set('images', $images);
        $this->data->set('title_compiled', $title_compiled);
        $this->data->set('title', $attraction['title']);

        return $this->view('viewer.gallery');
    }

    public function map($title_compiled)
    {
        $attraction = Attraction::where('title_compiled', '=', $title_compiled)->first();
        if ($attraction == null) {
            return $this->error('Attraction not found');
        }
        $attraction = $attraction->toArray();

        $locations = Attractions_Close_Locations::where("belonged_attraction", $attraction['id'])->get();

        $this->data->set('title_compiled', $title_compiled);
        $this->data->set("lat", $attraction["lat"]);
        $this->data->set("lon", $attraction["lon"]);
        $this->data->set("locations", $locations);

        return $this->view('viewer.map');
    }
}
