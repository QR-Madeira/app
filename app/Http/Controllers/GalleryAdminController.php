<?php

namespace App\Http\Controllers;

use App\Models\Attractions_Pictures;
use Illuminate\Http\Request;
use App\Models\Attraction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use function App\Auth\check;

use Intervention\Image\Facades\Image;

use const App\Auth\P_MANAGE_ATTRACTION;
use const App\Auth\P_VIEW_ATTRACTION;

class GalleryAdminController extends Controller
{
    public function create(Request $request)
    {
        if (!check(Auth::user(), P_MANAGE_ATTRACTION)) {
            return redirect()->back();
        }

        $validated = $request->validate([
            'belonged_attraction' => 'required'
        ]);
        
        $gallery = $request->file('gallery');

        if (is_iterable($gallery)) {
            foreach ($gallery as $img) {
                $store = explode("/", $img->store('gallery', 'public'))[1];
                Attractions_Pictures::create(array(
                    'belonged_attraction' => $validated['belonged_attraction'],
                    'image_path' => $store,
                ));
                Storage::disk('public')->put(
                    "gallery_resize/$store",
                    Image::make($img->getRealPath())
                        ->resize(500, 500, static function ($constraint) {
                            $constraint->aspectRatio();
                            $constraint->upsize();
                        })->stream()->detach(),
                    "public"
                );
                Storage::disk('public')->put(
                    "gallery_thumbnail/$store",
                    Image::make($img->getRealPath())
                        ->resize(150, 150, static function ($constraint) {
                            $constraint->aspectRatio();
                            $constraint->upsize();
                        })->stream()->detach(),
                    "public"
                );
            }
        }

        return redirect()->back();
    }

    public function list($id)
    {
        if (!check(Auth::user(), P_VIEW_ATTRACTION)) {
            return redirect()->back();
        }

        $attr = Attraction::find($id);

        if (!$attr) {
            return redirect()->back();
        }

        $title = Attraction::where('id', '=', $id)->first()->toArray()['title'];
        $images = Attractions_Pictures::where('belonged_attraction', '=', $id)->get()->toArray();
        foreach ($images as $key => $value) {
            $images[$key]['image_path'] = '/storage/gallery_thumbnail/' . $value['image_path'];
        }

        $this->data->set('images', $images);
        $this->data->set('belonged_attraction', $id);
        $this->data->set('id', $id);
        $this->data->set('title', $title);

        return $this->view('admin.list_gallery');
    }

    public function delete($id)
    {
        if (!check(Auth::user(), P_MANAGE_ATTRACTION)) {
            return redirect()->back();
        }

        $attr = Attractions_Pictures::find($id);

        if (!$attr) {
            return redirect()->back();
        }

        Storage::disk("public")->delete("gallery/$attr->image_path");
        Storage::disk("public")->delete("gallery_thumbnail/$attr->image_path");
        Attractions_Pictures::destroy($id);
        return redirect()->back();
    }
}
