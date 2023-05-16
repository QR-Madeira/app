<?php

namespace App\Http\Controllers;

use App\Auth\NoPermissionsException;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use App\Models\Attractions_Pictures;
use Illuminate\Http\Request;
use App\Models\Attraction;
use App\Models\User;

use function App\Auth\check;
use function App\Auth\checkOrThrow;

use const App\Auth\P_MANAGE_ATTRACTION;
use const App\Auth\P_VIEW_ATTRACTION;

class AttractionsAdminController extends Controller
{
    private $qrCodeMakerApiUrl = 'https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=';

    public function creator(Request $request)
    {
        $u = Auth::user();

        try {
          checkOrThrow($u, P_MANAGE_ATTRACTION);
        } catch (NoPermissionsException $e) {
          return $this->error($e->__toString());
        }

        Session::put('place', 'admin_attr');

        $this->data->set('created', $request->session()->get('status'));
        $this->data->set('route', $request->session()->get('route'));

        return $this->view('admin.create');
    }

    public function updater(Request $req, string $id)
    {
        $u = Auth::user();

        try {
          checkOrThrow($u, P_MANAGE_ATTRACTION);
        } catch (NoPermissionsException $e) {
          return $this->error($e->__toString());
        }

        $a = Attraction::find($id);

        if (!$a) {
            return redirect()->back();
        }

        if (Auth::id() === $a->created_by || $u->super) {
            foreach (
                [
                    "id" => $id,
                    "title" => $a->title,
                    "description" => $a->description,
                    "img" => '/storage/attractions/' . $a->image_path,
                    "lat" => $a->lat,
                    "lon" => $a->lon,
                ] as $k => $v
            ) {
                $this->data->set($k, $v);
            }
            return $this->view('admin.update');
        } else {
            return redirect()->back();
        }
    }

    public function create(Request $request)
    {
        try {
          checkOrThrow(Auth::user(), P_MANAGE_ATTRACTION);
        } catch (NoPermissionsException $e) {
          return $this->error($e->__toString());
        }

        $in = $request->validate([
          'title' => 'required|unique:attractions,title',
          'description' => 'required',
          'lat' => 'required',
          'lon' => 'required',
          //'image' => 'required',
        ]);

        $image = $request->file('image');
        $gallery = $request->file('gallery');

        $site_url = (($_SERVER["HTTPS"] ?? null) ? "https" : "http") . "://$_SERVER[HTTP_HOST]/" . urlencode($this->compileTitle($in['title']));

        $nomeArquivo = 'qr-codes/' . $this->compileTitle($in['title']) . '.png';

        $conteudo = file_get_contents($this->qrCodeMakerApiUrl . $site_url);

        $attraction = Attraction::create([
            'title_compiled' => $this->compileTitle($in['title']),
            'title' => $in['title'],
            'description' => $in['description'],
            'site_url' => $site_url,
            'image_path' => explode("/", $image->store('attractions', 'public'))[1],
            'qr-code_path' => $this->compileTitle($in['title']) . '.png',
            'created_by' => Auth::id(),
            "lat" => $in["lat"],
            "lon" => $in["lon"],
        ]);
        Storage::disk('public')->put($nomeArquivo, $conteudo, 'public');
        $image->store('attractions', 'public');

        if (is_iterable($gallery)) {
            foreach ($gallery as $picture) {
                $image_path = explode("/", $picture->store('gallery', 'public'))[1];
                $image = array(
                    'belonged_attraction' => $attraction->id,
                    'image_path' => $image_path,
                );
                Attractions_Pictures::create($image);
            }
        }

        $request->session()->flash('status', true);
        $request->session()->flash('route', route('view', [
            'title_compiled' => $this->compileTitle($in['title'])
        ]));
        return redirect()->route('admin.creator.attraction');
    }

    public function update(Request $request, string $id)
    {
        try {
          checkOrThrow(Auth::user(), P_MANAGE_ATTRACTION);
        } catch (NoPermissionsException $e) {
          return $this->error($e->__toString());
        }

        $a = Attraction::find($id);

        if (!$a) {
            // Attraction does not exist
            return redirect()->back();
        }

        if ($a->created_by === Auth::id() || Auth::user()->super) {
            $in = $request->validate([
                'title' => 'required',
                'description' => 'required',
            ]);

            $lat = !$request->post("lat") ? $a['lat'] : $request->post("lat");
            $lon = !$request->post("lon") ? $a['lon'] : $request->post("lon");

            $image = $request->file('image');

            $site_url = (($_SERVER["HTTPS"] ?? null) ? "https" : "http") . "://$_SERVER[HTTP_HOST]/" . urlencode($this->compileTitle($in['title']));

            $nomeArquivo = "qr-codes/" . $this->compileTitle($in["title"]) . ".png";

            $main_img = $a->image_path;

            if ($a->title_compiled != $this->compileTitle($in['title'])) {
                $conteudo = file_get_contents($this->qrCodeMakerApiUrl . $site_url);
                Storage::disk('public')->delete("qr-codes/$a->title_compiled.png");
                Storage::disk('public')->put($nomeArquivo, $conteudo, 'public');
            }

            $raw = [
                'title_compiled' => $this->compileTitle($in['title']),
                'title' => $in['title'],
                'description' => $in['description'],
                'site_url' => $site_url,
                'qr-code_path' => $this->compileTitle($in['title']) . '.png',
                "lat" => $lat,
                "lon" => $lon,
            ];

            if ($image !== null) {
                $raw["image_path"] = explode("/", $image->store("attractions", "public"))[1];
            }

            $a->update($raw);

            if ($image != null) {
                Storage::disk("public")->delete("attractions/$main_img");
            }

            return redirect(status: 204)->route("admin.edit.attraction", $id);
        } else {
            // Not the owner neither a super user
            return redirect()->back();
        }
    }

    private function compileTitle(string $title)
    {
        $tabela = array(
            'Á' => 'A', 'á' => 'a', 'Â' => 'A', 'â' => 'a', 'Ã' => 'A', 'ã' => 'a',
            'É' => 'E', 'é' => 'e', 'Ê' => 'E', 'ê' => 'e',
            'Í' => 'I', 'í' => 'i', 'Î' => 'I', 'î' => 'i',
            'Ó' => 'O', 'ó' => 'o', 'Ô' => 'O', 'ô' => 'o', 'Õ' => 'O', 'õ' => 'o',
            'Ú' => 'U', 'ú' => 'u', 'Û' => 'U', 'û' => 'u'
        );
        $title = strtr($title, $tabela);
        $title = str_replace(" ", "-", $title);
        $title = strtolower($title);
        return $title;
    }

    public function delete($id)
    {
      try {
        checkOrThrow(Auth::user(), P_MANAGE_ATTRACTION);
      } catch (NoPermissionsException $e) {
        return $this->error($e->__toString());
      }

      $attr = Attraction::find($id);

      if (!$attr) {
        return redirect()->back();
      }

      Attractions_Pictures::where('belonged_attraction', $id)->delete();
      Attraction::destroy($id);
      return redirect()->route('admin.list.attraction');
    }

    public function list()
    {
        if (!check(Auth::user(), P_VIEW_ATTRACTION)) {
          return redirect()->back();
        }

        Session::put('place', 'admin_attr');

        $all_attractions = Attraction::all();

        for ($i = 0; $i < count($all_attractions); $i++) {
            $all_attractions[$i]['image'] = asset('storage/attractions/' . $all_attractions[$i]->image_path);
            $all_attractions[$i]['qr-code'] = asset('storage/qr-codes/' . $all_attractions[$i]['qr-code_path']);
            $creator_name = User::select('name')->where('id', $all_attractions[$i]['created_by'])->first();
            $all_attractions[$i]['creator_name'] = $creator_name->name;
        }

        $this->data->set('attractions', $all_attractions);

        return $this->view('admin.list');
    }
}
