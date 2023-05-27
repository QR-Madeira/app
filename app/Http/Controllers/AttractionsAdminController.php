<?php

namespace App\Http\Controllers;

use App\FormValidation\Core\FormValidationException;
use App\FormValidation\Attraction as AttractionValidation;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use App\Models\Attractions_Pictures;
use App\Models\Attraction;
use App\Models\AttractionDescriptions;
use App\Models\Attractions_Close_Locations;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

use const App\Auth\P_MANAGE_ATTRACTION;
use const App\Auth\P_VIEW_ATTRACTION;

use Intervention\Image\Facades\Image;

class AttractionsAdminController extends Controller
{
    private const QR_FORMAT = 'svg';

    public function creator()
    {
        $v = $this->verify(P_MANAGE_ATTRACTION);
        if ($v !== null) {
            return $v;
        }

        Session::put(static::PLACE, "admin_attr");

        $this->data->set("langs", ["pt", "en"]);
        $this->data->set("cur_lang", App::currentLocale());

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
            $this->data->set("isPUT", true);
            $this->data->set("langs", ["pt", "en"]);
            $this->data->set("cur_lang", session("lastLang", App::currentLocale()));
            $desc = $a->description->where("language", $this->data->get()["cur_lang"])->first() ?? null;

            $this->data->set("description", $desc?->description ?? "");

            return $this->view('admin.create');
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

        $desc = AttractionDescriptions::create([
            "description" => $in["description"],
            "language" => $in["description_lang"],
            "attraction_id" => $a->id,
        ]);

        if (!$desc) {
            Attraction::destroy($a->id);

            // TODO: single form of showing errors
            Session::flash("status", false);
            Session::flash("message", "Something went wrong, try again.");

            return $this->error("Something went wrong, try again.");
        }

        Storage::disk("public")
            ->put("qr-codes/$in[qr_code_path]", file_get_contents(
                $this->getQrCodeUrl($in["site_url"])
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
                $store = explode("/", $picture->store("gallery", "public"))[1];
                Attractions_Pictures::create([
                    "belonged_attraction" => $a->id,
                    "image_path" => $store,
                ]);
                Storage::disk('public')->put(
                    "gallery_thumbnail/$store",
                    Image::make($picture->getRealPath())
                        ->resize(150, 150, static function ($constraint) {
                            $constraint->aspectRatio();
                            $constraint->upsize();
                        })->stream()->detach(),
                    "public"
                );
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

        $desc = $a->description->where("language", $in["description_lang"])->first();

        $data = [
            "description" => $in["description"],
            "language" => $in["description_lang"],
            "attraction_id" => $a->id,
        ];
        if ($desc === null) {
            $a->description()->save(new AttractionDescriptions($data));
        } else {
            $desc->update([
                "description" => $in["description"],
            ]);
        }

        if ($a->title_compiled != $in["title_compiled"]) {
            Storage::disk("public")->delete("qr-codes/$a->title_compiled." . self::QR_FORMAT);
            Storage::disk("public")
                ->put("qr-codes/" . $in['qr_code_path'], file_get_contents(
                    $this->getQrCodeUrl($in["site_url"])
                ), "public");
        }

        if ($request->file('image') !== null) {
            Storage::disk("public")->delete("thumbnail/$a->title_compiled.png");
            Storage::disk('public')
                ->put(
                    "thumbnail/" . $in['title_compiled'] . ".png",
                    Image::make($request->file("image")->getRealPath())
                        ->resize(150, 150, static function ($constraint) {
                            $constraint->aspectRatio();
                            $constraint->upsize();
                        })
                        ->stream()
                        ->detach(),
                    "public"
                );
        }

        return redirect(status: 204)
            ->route("admin.edit.attraction", $id)
            ->with("lastLang", (null !== $request->post("submited")) ? $in["description_lang"] : ($in["description_lang"] === "en" ? "pt" : "en"));
    }

    public function delete($id)
    {
        $v = $this->verify(P_MANAGE_ATTRACTION);
        if ($v !== null) {
            return $v;
        }

        $a = Attraction::find($id);

        if (!$a) {
            return $this->error('Attraction does not exists');
        }

        if (!$a->created_by === Auth::id() || !Auth::user()->super) {
            return $this->error('Not the owner neither a super user');
        }

        $pics = Attractions_Pictures::where('belonged_attraction', $id);
        $pictures = $pics->get()->toArray();
        if ($pictures != null) {
            for ($i = 0; $i < count($pictures); $i++) {
                Storage::disk("public")->delete("gallery/" . $pictures[$i]['image_path']);
                Storage::disk("public")->delete("gallery_thumbnail/" . $pictures[$i]['image_path']);
            }
        }

        Storage::disk("public")->delete("qr-codes/$a[title_compiled]." . self::QR_FORMAT);
        Storage::disk("public")->delete("attractions/$a[image]");
        Storage::disk("public")->delete("thumbnail/$a[title_compiled].png");
        $pics->delete();
        Attractions_Close_Locations::where('belonged_attraction', $id)->delete();

        Attraction::destroy($id);

        return redirect()->route('admin.list.attraction');
    }

    public function list()
    {
        $v = $this->verify(P_VIEW_ATTRACTION);
        if ($v !== null) {
            return $v;
        }

        Session::put(self::PLACE, 'admin_attr');

        $all_attractions = Attraction::cursorPaginate(10);

        foreach ($all_attractions as &$attr) {
            $attr["image"] = asset("storage/attractions/$attr->image_path");
            $attr["qr-code"] = asset("storage/qr-codes/$attr->qr_code_path");
            $attr["creator_name"] = User::select("name")
                ->where("id", $attr["created_by"])
                ->first()->name;

            $desc = $attr["description"]->where("language", App::currentLocale());
            if ($desc->first() == null) {
                $attr["description"] = $attr["description"]->where("language", "!=", App::currentLocale())->random();
            } else {
                $attr["description"] = $desc->first();
            }

            $attr["description"] = $attr["description"]->description ?? "";
        }

        $this->data->set('attractions', $all_attractions);

        return $this->view('admin.list');
    }

    private function getQrCodeUrl(string $site): string
    {
        return "https://api.qrserver.com/v1/create-qr-code/?format="
            . self::QR_FORMAT
            . "&data=$site";
    }
}
