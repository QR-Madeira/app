<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attraction;

class AttractionsViewerController extends Controller
{
  public function index($title_compiled)
  {
    $attraction = Attraction::where('title_compiled', '=', $title_compiled)->first()->toArray();
    $description = nl2br($attraction['description']);
    $data = array(
      'image' => 'storage/attractions/'.$attraction['image_path'],
      'title' => $attraction['title'],
      'description' => $description
    );
    return view('viewer.get', $data);
  }
}
