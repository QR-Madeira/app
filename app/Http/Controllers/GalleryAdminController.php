<?php

namespace App\Http\Controllers;

use App\Models\Attractions_Pictures;
use Illuminate\Http\Request;
use App\Models\Attraction;

class GalleryAdminController extends Controller
{
    public function create(Request $request)
    {
      $validated = $request->validate([
        'belonged_attraction' => 'required'
      ]);

      $gallery = $request->file('gallery');
      
      foreach($gallery as $img)
        Attractions_Pictures::create(array(
          'belonged_attraction' => $validated['belonged_attraction'],
          'image_path' => explode("/", $img->store('gallery', 'public'))[1],
        ));

      return redirect()->back();
    }

    public function list($id)
    {
      $title = Attraction::where('id', '=', $id)->first()->toArray()['title'];
      $images = Attractions_Pictures::where('belonged_attraction', '=', $id)->get()->toArray();
      foreach ($images as $key => $value) {
        $images[$key]['image_path'] = '/storage/gallery/' . $value['image_path'];
      }
      
      $this->data->set('images', $images);
      $this->data->set('belonged_attraction', $id);
      $this->data->set('id', $id);
      $this->data->set('title', $title);

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
