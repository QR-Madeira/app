<?php

namespace App\Http\Controllers;

use App\FormValidation\Core\FormValidationException;
use App\FormValidation\Site as SiteValidation;

use Illuminate\Http\Request;
use App\Models\Site;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;


class SiteController extends Controller
{
    public function updater()
    {
        /*$v = $this->verify(P_MANAGE_USER);
        if ($v !== null) {
            return $v;
        }*/

        Session::put('place', 'admin_site');

        $siteInfo = $this->getFirst();
        
        if (!$siteInfo) {
            return $this->error("Page not found");
        }

        $this->data->set("siteInfo", $siteInfo);

        return $this->view("admin.edit_site");
    }

    public function update()
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
        dd($this->getFirst()->get());
        $status = Site::update($in);
        dd($status);
        Session::flash("status", $status);
        Session::flash("message", $status === true?"Information updated with success." : "Something went wrong.");

        return redirect()->route("admin.edit.site");
    }

    public function getFirst(){
        return Site::first();
    }

}
