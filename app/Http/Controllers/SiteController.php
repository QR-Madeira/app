<?php

namespace App\Http\Controllers;

use App\FormValidation\Core\FormValidationException;
use App\FormValidation\Site as SiteValidation;

use Illuminate\Http\Request;
use App\Models\Site;
use App\Models\SiteDescriptions;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

use const App\Auth\P_MANAGE_SITE;


class SiteController extends Controller
{
    public function updater()
    {
        $v = $this->verify(P_MANAGE_SITE);
        if ($v !== null) {
            return $v;
        }

        Session::put('place', 'admin_site');

        $siteInfo = $this->getFirst();
        if (!$siteInfo) {
            return $this->error("Page not found");
        }

        $this->data->set("cur_lang", session("lastLang", App::currentLocale()));
        $this->data->set("langs", ["pt", "en"]);
        $desc = $siteInfo->desc->where("language", $this->data->get()["cur_lang"])->first() ?? null;
        $socials = $siteInfo->socials();
        $siteInfo = $siteInfo->toArray();
        $siteInfo["desc"] = $desc?->description ?? "";
        $siteInfo["socials"] = $socials;
        foreach ($siteInfo as $k => $v) {
            $this->data->set($k, $v);
        }

        return $this->view("admin.edit_site");
    }

    public function update(Request $request)
    {
        $v = $this->verify(P_MANAGE_SITE);
        if ($v !== null) {
            return $v;
        }

        try {
            $in = SiteValidation::verify($request);
        } catch (FormValidationException $e) {
            return $this->error($e->getMessage());
        }
        $siteInfo = $this->getFirst();
        $status = $siteInfo->update($in);
        $desc = $siteInfo->desc->where("language", $in["description_lang"])->first();

        $data = [
            "description" => $in["desc"],
            "language" => $in["description_lang"],
            "site_id" => $siteInfo->id,
        ];
        if ($desc === null) {
            $siteInfo->desc()->save(new SiteDescriptions($data));
        } else {
            $desc->update([
                "description" => $in["desc"],
            ]);
        }

        Session::flash("status", $status);
        Session::flash("message", $status === true ? "Information updated with success." : "Something went wrong.");
        Session::flash("lastLang", (null !== $request->post("submited")) ? $in["description_lang"] : ($in["description_lang"] === "en" ? "pt" : "en"));

        return redirect()->route("admin.edit.site");
    }

    public function getFirst()
    {
        return Site::first();
    }
}
