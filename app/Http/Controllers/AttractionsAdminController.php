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

use Intervention\Image\Facades\Image;

class AttractionsAdminController extends Controller
{
    public function creator(Request $request)
    {
        $u = Auth::user();
        try {
            checkOrThrow($u, P_MANAGE_ATTRACTION);
        } catch (NoPermissionsException $e) {
            return $this->error($e->__toString());
        }

        Session::put('place', 'admin_attr');

        //$this->data->set('status', $request->session()->get('status'));
        //$this->data->set('route', $request->session()->get('route'));

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
                    "img" => '/storage/thumbnail/' . $a->title_compiled . ".png",
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
          'size' => 'required',
        ]);

        $image = $request->file('image');
        $gallery = $request->file('gallery');

        if ($image == null) {
            return $this->error('Image is missing');
        }

        $site_url = (($_SERVER["HTTPS"] ?? null) ? "https" : "http") . "://$_SERVER[HTTP_HOST]/" . urlencode($this->compileTitle($in['title']));

        $nomeArquivo = 'qr-codes/' . $this->compileTitle($in['title']) . '.png';

        $conteudo = file_get_contents($this->getQrCodeUrl($in['size'], $site_url));

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

        if(!$attraction){
            Session::flash('status', false);
            Session::flash('message', "Something went wrong, try again.");
            return redirect()->route('admin.creator.attracion');
        }

        Storage::disk('public')->put($nomeArquivo, $conteudo, 'public');

        $image_thumbnail_path = "thumbnail/".$attraction->title_compiled. ".png";
        $image_thumbnail = Image::make($image->getRealPath())->resize(150, 150, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        })->stream()->detach();
        Storage::disk('public')->put($image_thumbnail_path, $image_thumbnail, 'public');

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

        Session::flash('status', true);
        Session::flash('route', route('view', [
            'title_compiled' => $this->compileTitle($in['title'])
        ]));
        return redirect()->route('admin.creator.location', array('id' => $attraction->id));
    }

    public function getQrCodeUrl($size, $site)
    {
        $url = "https://api.qrserver.com/v1/create-qr-code/?size=" . $size . "x" . $size . "&data=" . $site;
        return $url;
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
            return $this->error('Attraction does not exists');
        }

        if (!$a->created_by === Auth::id() && !Auth::user()->super) {
            return $this->error('Not the owner neither a super user');
        }

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

        $all_attractions = Attraction::cursorPaginate(5);

        foreach ($all_attractions as $attr) {
            $attr['image'] = asset('storage/attractions/' . $attr->image_path);
            $attr['qr-code'] = asset('storage/qr-codes/' . $attr['qr-code_path']);
            $creator_name = User::select('name')->where('id', $attr['created_by'])->first();
            $attr['creator_name'] = $creator_name->name;
        }

        $this->data->set('attractions', $all_attractions);

        return $this->view('admin.list');
    }
}
