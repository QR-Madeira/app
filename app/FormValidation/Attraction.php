<?php

/**
 * @package App\\FormValidation
 * @author João Augusto Costa Branco Marado Torres <torres.dev@disroot.org>
 * @copyright Copyright (C) 2023  Danilo Kymhyr, João Augusto Costa Branco Marado Torres, Leonardo Abreu de Paulo
 */

declare(encoding="UTF-8");

declare(strict_types=1);

namespace App\FormValidation;

use App\FormValidation\Core\FormRule;
use App\FormValidation\Core\FormValidator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

final class Attraction extends FormValidator
{
    public function getRules(Request $req): array
    {
        $name = FormRule::new("title")->required();
        $rules = [
            FormRule::new("description")->required(),
            FormRule::new("lat")->required(),
            FormRule::new("lon")->required(),
        ];

        switch ($req->getMethod()) {
            case "POST":
                $name = $name->unique("attractions", "title");
                $rules[] = FormRule::new("image")->required();
                $rules[] = FormRule::new("size")->required();
                $rules[] = $name;
                return $rules;
            case "PUT":
                $rules[] = $name;
                return $rules;
        }

        return [];
    }

    public function postProcess(array $in): array
    {
        $in["title_compiled"] = $this->compileTitle($in['title']);
        $in["site_url"] = $this->base(urlencode($in["title_compiled"]));
        $in["qr_code_path"] = "$in[title_compiled].svg";
        $in["created_by"] = Auth::id();

        if (!empty($i = ($in["image"] ?? null))) {
            $in["image"] = explode("/", $i->store('attractions', 'public'))[1];
        }

        return $in;
    }

    private function compileTitle(string $title)
    {
        return strtolower(str_replace(" ", "-", strtr($title, [
            'Á' => 'A', 'á' => 'a', 'Â' => 'A', 'â' => 'a', 'Ã' => 'A', 'ã' => 'a',
            'É' => 'E', 'é' => 'e', 'Ê' => 'E', 'ê' => 'e',
            'Í' => 'I', 'í' => 'i', 'Î' => 'I', 'î' => 'i',
            'Ó' => 'O', 'ó' => 'o', 'Ô' => 'O', 'ô' => 'o', 'Õ' => 'O', 'õ' => 'o',
            'Ú' => 'U', 'ú' => 'u', 'Û' => 'U', 'û' => 'u'
        ])));
    }

    private function base(string $path): string
    {
        return (($_SERVER["HTTPS"] ?? null) ? "https" : "http") . "://$_SERVER[HTTP_HOST]/$path";
    }
}
