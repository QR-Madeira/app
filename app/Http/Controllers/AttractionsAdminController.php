<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use App\Models\Attractions_Pictures;
use Illuminate\Http\Request;
use App\Models\Attraction;
use App\Models\User;
use DateTime;

class AttractionsAdminController extends Controller
{
    private $qrCodeMakerApiUrl = 'https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=';

    public function creator(Request $request)
    {
        Session::put('place', 'admin_attr');

        $status = $request->session()->get('status');
        $route = $request->session()->get('route');

        $this->data->set('created', $status);
        $this->data->set('route', $route);

        return $this->view('admin.create');
    }

    public function updater(Request $req, string $id)
    {
        $a = Attraction::find($id);

        if (!$a || !$id) {
            throw new \RuntimeException("no attraction found");
        }

        if (Auth::id() === $a->created_by) {
            foreach (
                [
                "id" => $id,
                "title" => $a->title,
                "description" => $a->description,
                "img" => $a->image_path,
                ] as $k => $v
            ) {
                $this->data->set($k, $v);
            }
            return $this->view('admin.update');
        } else {
            throw new \RuntimeException("not the owner of the attraction");
        }
    }

    public function create(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|unique:attractions,title',
            'description' => 'required'
        ]);

        $image = $request->file('image');
        $gallery = $request->file('gallery');

        $site_url = (($_SERVER["HTTPS"] ?? null) ? "https" : "http") . "://$_SERVER[HTTP_HOST]/" . urlencode($this->compileTitle($validatedData['title']));

        $nomeArquivo = 'qr-codes/' . $this->compileTitle($validatedData['title']) . '.png';

        $conteudo = file_get_contents($this->qrCodeMakerApiUrl . $site_url);
        Storage::disk('public')->put($nomeArquivo, $conteudo, 'public');
        $image->store('attractions', 'public');
        $attraction = Attraction::create([
            'title_compiled' => $this->compileTitle($validatedData['title']),
            'title' => $validatedData['title'],
            'description' => $validatedData['description'],
            'site_url' => $site_url,
            'image_path' => explode("/", $image->store('attractions', 'public'))[1],
            'qr-code_path' => $this->compileTitle($validatedData['title']) . '.png',
            'created_by' => Auth::id()
        ]);

        foreach ($gallery as $picture) {
            $image_path = $picture->store('gallery', 'public');
            $image = array(
                'belonged_attraction' => $attraction->id,
                'image_path' => $image_path,
            );
            Attractions_Pictures::create($image);
        }

        $request->session()->flash('status', true);
        $request->session()->flash('route', route('view', ['title_compiled' => $this->compileTitle($validatedData['title'])]));
        return redirect()->route('admin.creator');
    }

    public function update(Request $request, ?string $id = null)
    {
        $validatedData = $request->validate([
            'title' => 'required',
            'description' => 'required'
        ]);

        $image = $request->file('image');
        $gallery = $request->file('gallery');

        $site_url = (($_SERVER["HTTPS"] ?? null) ? "https" : "http") . "://$_SERVER[HTTP_HOST]/" . urlencode($this->compileTitle($validatedData['title']));

        $nomeArquivo = 'qr-codes/' . $this->compileTitle($validatedData['title']) . '.png';

        $a = Attraction::find($id);

        if (!$a || !$id) {
            throw new \RuntimeException("no attraction found");
        }

        if ($a->created_by === Auth::id()) {
            $toDel = Attractions_Pictures::where("belonged_attraction", $id)->get()->map(static fn (Attractions_Pictures $i) => $i->image_path);
            $main_img = $a->image_path;

            if ($a->title_compiled != $this->compileTitle($validatedData['title'])) {
                $conteudo = file_get_contents($this->qrCodeMakerApiUrl . $site_url);
                Storage::disk('public')->delete("qr-codes/$a->title_compiled.png");
                Storage::disk('public')->put($nomeArquivo, $conteudo, 'public');
            }

            $raw = [
                'title_compiled' => $this->compileTitle($validatedData['title']),
                'title' => $validatedData['title'],
                'description' => $validatedData['description'],
                'site_url' => $site_url,
                'qr-code_path' => $this->compileTitle($validatedData['title']) . '.png',
            ];

            if ($image !== null) {
                $raw["image_path"] = explode("/", $image->store("attractions", "public"))[1];
            }

            $a->update($raw);

            if ($image != null) {
                Storage::disk("public")->delete("attractions/$main_img");
            }

            if (is_iterable($gallery)) {
                foreach ($gallery as $picture) {
                    $image_path = $picture->store('gallery', 'public');
                    $image = array(
                        'belonged_attraction' => $id,
                        'image_path' => $image_path,
                    );
                    Attractions_Pictures::create($image);
                }
            }

            Storage::disk("public")->delete($toDel);

            return redirect(status: 204)->route("admin.updater", $id);
        } else {
            throw new \RuntimeException("Not the owner of /the attraction");
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
        Attraction::destroy($id);
        return redirect()->route('admin.list');
    }

    public function list()
    {
        Session::put('place', 'admin_attr');

        $all_attractions = Attraction::all();

        for ($i = 0; $i < count($all_attractions); $i++) {
            $all_attractions[$i]['image'] = asset('storage/attractions/' . $all_attractions[$i]->image_path);
            $all_attractions[$i]['qr-code'] = asset('storage/qr-codes/' . $all_attractions[$i]['qr-code_path']);
            $creator_name = User::select('name')->where('id', $all_attractions[$i]['created_by'])->first();
            $all_attractions[$i]['creator_name'] = $creator_name->name;
            $date = new DateTime($all_attractions[$i]['created_at']);
            $all_attractions[$i]['created_at_'] = $date->format("Y-m-d");
        }

        $this->data->set('attractions', $all_attractions);

        return $this->view('admin.list');
    }
}
