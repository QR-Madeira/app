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
    return $this->view('admin.list_gallery');
  }
}
