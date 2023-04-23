<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attraction;
use Illuminate\Support\Facades\Storage;

class AttractionsAdminController extends Controller
{
  private $qrCodeMakerApiUrl = 'https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=';

  public function creator(Request $request)
  {
    $status = $request->session()->get('status');
    $route = $request->session()->get('route');
    $data = array(
      'created' => $status,
      'route' => $route
    );
    return view('admin.create', $data);
  }

  public function create(Request $request)
  {
    $validatedData = $request->validate([
      'title' => 'required|unique:attractions,title',
      'description' => 'required'
    ]);

    $title = $validatedData['title'];

    $description = $validatedData['description'];

    $image_path = $request->file('image')->store('attractions', 'public');
    
    $image_path = explode('/', $image_path)[1];

    $site_url = env('APP_URL').$this->compileTitle($validatedData['title']);

    $nomeArquivo = 'qr-codes/'.$this->compileTitle($validatedData['title']).'.png';
    $conteudo = file_get_contents($this->qrCodeMakerApiUrl.$site_url);
    Storage::disk('public')->put($nomeArquivo, $conteudo, 'public');
    
    $attraction = [
      'title_compiled' => $this->compileTitle($validatedData['title']),
      'title' => $validatedData['title'],
      'description' => $validatedData['description'],
      'site_url' => $site_url,
      'image_path' => $image_path,
      'qr-code_path' => $this->compileTitle($validatedData['title']).'.png',
      'created_by' => 1
    ];
    
    Attraction::create($attraction);

    $request->session()->flash('status', true);
    $request->session()->flash('route', route('view', ['title_compiled' => $this->compileTitle($validatedData['title'])]));
    return redirect()->route('admin.creator');
  }

  private function compileTitle(String $title)
  {
    $tabela = array(
      'Á'=>'A', 'á'=>'a', 'Â'=>'A', 'â'=>'a', 'Ã'=>'A', 'ã'=>'a',
      'É'=>'E', 'é'=>'e', 'Ê'=>'E', 'ê'=>'e',
      'Í'=>'I', 'í'=>'i', 'Î'=>'I', 'î'=>'i',
      'Ó'=>'O', 'ó'=>'o', 'Ô'=>'O', 'ô'=>'o', 'Õ'=>'O', 'õ'=>'o',
      'Ú'=>'U', 'ú'=>'u', 'Û'=>'U', 'û'=>'u'
    );
    $title = strtr($title, $tabela);
    $title = str_replace(" ", "-", $title);
    $title = strtolower($title);
    return $title;
  }

  public function delete($id)
  {
    Attraction::destroy($id);
    return redirect()->route('admin.list');
  }

  public function list(Request $request)
  {
    $all_attractions = Attraction::all();
    
    for($i = 0; $i < count($all_attractions); $i++)
    {
      $all_attractions[$i]['image'] = asset('storage/attractions/'.$all_attractions[$i]->image_path);
      $all_attractions[$i]['qr-code'] = asset('storage/qr-codes/'.$all_attractions[$i]['qr-code_path']);
    }
    
    $data = array(
      'attractions' => $all_attractions
    );

    return view('admin.list', $data);
  }
}
