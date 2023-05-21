<?php

/**
 * @package App\\FormValidation
 * @author João Augusto Costa Branco Marado Torres <torres.dev@disroot.org>
 * @author Danilo Kymhyr <danilokymhyr@gmail.com>
 * @copyright Copyright (C) 2023  Danilo Kymhyr, João Augusto Costa Branco Marado Torres, Leonardo Abreu de Paulo
 */

declare(encoding="UTF-8");
declare(strict_types=1);

namespace App\FormValidation;

use App\Classes\PasswordHash;
use App\FormValidation\Core\FormRule;
use App\FormValidation\Core\FormValidator;
use Illuminate\Http\Request;

final class Verification extends FormValidator
{
    public function getRules(Request $req): array
    {
        return [
            FormRule::new("email")->required()->email(),
            FormRule::new("code")->required()->string(),
            FormRule::new("password")->required()->min(6)->confirmed(),
        ];
    }

    public function postProcess(array $in): array
    {
        $hash = new PasswordHash(10, false);
        $in["password"] = $hash->HashPassword($in["password"]);

        return $in;
    }
}
