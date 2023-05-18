<?php

namespace App\Http\Controllers;

use App\Auth\NoPermissionsException;
use App\FormValidation\Core\FormValidationException;
use App\FormValidation\Attraction as AttractionValidation;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use App\Models\Attractions_Pictures;
use App\Models\Attraction;
use App\Models\User;
use Illuminate\Http\Request;

use function App\Auth\checkOrThrow;

use const App\Auth\P_MANAGE_ATTRACTION;

use Intervention\Image\Facades\Image;

class AttractionsAdminController extends Controller
{
    public function creator()
    {
        $v = $this->verify(P_MANAGE_ATTRACTION);
        if ($v !== null) {
            return $v;
        }

        Session::put(static::PLACE, "admin_attr");

        return $this->view('admin.create');
    }

    public function updater(string $id)
    {
        $v = $this->verify(P_MANAGE_ATTRACTION);
        if ($v !== null) {
            return $v;
        }

        $a = Attraction::find($id);

        if (!$a) {
            return $this->error("No attracion to update");
        }

        if (Auth::id() === $a->created_by || Auth::user()->super) {
            $a->img = "/storage/thumbnail/$a->title_compiled.png";
            foreach ($a->toArray() as $k => $v) {
                $this->data->set($k, $v);
            }
            return $this->view('admin.update');
        } else {
            return $this->error("No ownership to update this attracion");
        }
    }

    public function create(Request $request)
    {
        $v = $this->verify(P_MANAGE_ATTRACTION);
        if ($v !== null) {
            return $v;
        }

        try {
            $in = AttractionValidation::verify($request);
        } catch (FormValidationException $e) {
            return $this->error($e->getMessage());
        }

        $a = Attraction::create($in);

        if (!$a) {
            // TODO: single form of showing errors
            Session::flash("status", false);
            Session::flash("message", "Something went wrong, try again.");

            return $this->error("Something went wrong, try again.");
        }

        Storage::disk("public")
            ->put("qr-codes/$in[qr_code_path]", file_get_contents(
                $this->getQrCodeUrl($in["size"], $in["site_url"])
            ), "public");

        Storage::disk('public')
            ->put(
                "thumbnail/$in[title_compiled].png",
                Image::make($request->file("image")->getRealPath())
                    ->resize(150, 150, static function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    })
                    ->stream()
                    ->detach(),
                "public"
            );

        if (is_iterable($gallery = ($in["gallery"] ?? null))) {
            foreach ($gallery as $picture) {
                Attractions_Pictures::create([
                    "belonged_attraction" => $a->id,
                    "image_path" => explode(
                        "/",
                        $picture->store("gallery", "public")
                    )[1],
                ]);
            }
        }

        Session::flash("status", true);
        Session::flash("route", route("view", [
            "title_compiled" => $in["title_compiled"]
        ]));

        return redirect()->route("admin.creator.location", ["id" => $a->id]);
    }

    public function update(Request $request, string $id)
    {
        $v = $this->verify(P_MANAGE_ATTRACTION);
        if ($v !== null) {
            return $v;
        }

        $a = Attraction::find($id);

        if (!$a) {
            return $this->error('Attraction does not exists');
        }

        if (!$a->created_by === Auth::id() && !Auth::user()->super) {
            return $this->error('Not the owner neither a super user');
        }

        try {
            $in = AttractionValidation::verify($request);
        } catch (FormValidationException $e) {
            return $this->error($e->getMessage());
        }

        $a->update($in);

        if ($a->title_compiled != $in["title_compiled"]) {
            Storage::disk("public")->delete("qr_codes/$a->title_compiled.png");
            Storage::disk("public")
                ->put("qr-codes/$in[qr_code_path]", file_get_contents(
                    $this->getQrCodeUrl($in["size"], $in["site_url"])
                ), "public");
        }

        if ($request->file('image') !== null) {
            // put new???
            Storage::disk("public")->delete("attractions/$a->image_path");
        }

        return redirect(status: 204)->route("admin.edit.attraction", $id);
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
        $v = $this->verify(P_MANAGE_ATTRACTION);
        if ($v !== null) {
            return $v;
        }

        Session::put('place', 'admin_attr');

        $all_attractions = Attraction::cursorPaginate(5);

        foreach ($all_attractions as $attr) {
            $attr['image'] = asset('storage/attractions/' . $attr->image_path);
            $attr['qr-code'] = asset('storage/qr-codes/' . $attr['qr_code_path']);
            $creator_name = User::select('name')->where('id', $attr['created_by'])->first();
            $attr['creator_name'] = $creator_name->name;
        }

        $this->data->set('attractions', $all_attractions);

        return $this->view('admin.list');
    }

    private function getQrCodeUrl(int $size, string $site): string
    {
        return "https://api.qrserver.com/v1/create-qr-code/?format=svg&size=$size"
            . "x$size&data=$site";
    }
}
