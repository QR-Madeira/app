<?php

namespace App\Http\Controllers;

use App\Models\Attractions_Pictures;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Attraction;

class GalleryAdminController extends Controller
{
  public function list($id)
  {
    $images = Attractions_Pictures::where('belonged_attraction', '=', $id)->get()->toArray();
    foreach($images as $key => $value){
      $images[$key]['image_path'] = '/storage/gallery/' . $value['image_path'];
    }
    $this->data->set('images', $images);

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
