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

use App\FormValidation\Core\FormRule;
use App\FormValidation\Core\FormValidator;
use Illuminate\Http\Request;
use App\Classes\PasswordHash;
use Illuminate\Support\Facades\Hash;

final class User_password extends FormValidator
{
    public function getRules(Request $req): array
    {
        $rules = [
            FormRule::new("old_password")->required()->string(),
            FormRule::new("password")->required()->min(6)->string()->confirmed(),
        ];

        return $rules;
    }

    public function postProcess(array $in): array
    {
        $hash = new PasswordHash(8, false);
        //$in['password'] = Hash::make($in['password']);
        //$in['old_password'] = $hash->HashPassword($in['old_password']);
        $in['password'] = $hash->HashPassword($in['password']);

        return $in;
    }
}
