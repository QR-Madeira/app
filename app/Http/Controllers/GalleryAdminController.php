<?php

namespace App\Http\Controllers;

use App\Models\Attractions_Pictures;
use Illuminate\Http\Request;

class GalleryAdminController extends Controller
{
    public function create(Request $request)
    {
        $validated = $request->validate([
        'belonged_attraction' => 'required'
        ]);
        $image = $request->file('image');
        $image_path = explode("/", $image->store('gallery', 'public'))[1];

        $image = array(
        'belonged_attraction' => $validated['belonged_attraction'],
        'image_path' => $image_path,
        );
        Attractions_Pictures::create($image);
        return redirect()->back();
    }

    public function list($id)
    {
        $images = Attractions_Pictures::where('belonged_attraction', '=', $id)->get()->toArray();
        foreach ($images as $key => $value) {
            $images[$key]['image_path'] = '/storage/gallery/' . $value['image_path'];
        }

        return $this->view('admin.list_gallery');
    }

    public function delete($id)
    {
        $loc = Attractions_Pictures::find($id);

        if (!$loc || !$id) {
            throw new \RuntimeException("Image not found");
        }

        Attractions_Pictures::destroy($id);
        return redirect()->back();
    }
}
