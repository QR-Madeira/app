<?php

namespace App\Http\Controllers;

use App\Models\Attraction;
use App\Models\Attractions_Pictures;
use App\Models\Attractions_Close_Locations;

class AttractionsViewerController extends Controller
{
    public function index($title_compiled)
    {
        $attraction = Attraction::where('title_compiled', '=', $title_compiled)->first();
        if ($attraction == null) {
            return $this->error('Attraction not found');
        }
        $attraction = $attraction->toArray();

        $description = nl2br($attraction['description']);

        $this->data->set('image', 'storage/attractions/' . $attraction['image']);
        $this->data->set('title_compiled', $title_compiled);
        $this->data->set('title', $attraction['title']);
        $this->data->set('description', $description);
        $this->data->set('qr', asset('storage/qr-codes/' .  $attraction["qr_code_path"]));
        $this->data->set("lat", $attraction["lat"]);
        $this->data->set("lon", $attraction["lon"]);

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
