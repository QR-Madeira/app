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

    $this->data->set('image', 'storage/attractions/' . $attraction['image_path']);
    $this->data->set('title', $attraction['title']);
    $this->data->set('description', $description);
    $this->data->set('qr', asset('storage/qr-codes/' .  $attraction["qr-code_path"]));

    return $this->view('viewer.get');
  }
}
