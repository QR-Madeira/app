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

final class Users extends FormValidator
{
    public function getRules(Request $req): array
    {
        $rules = [
            FormRule::new("name")->required()->minmax(3, 80),
            FormRule::new("permissions")->required()->array(),
        ];

        if ($req->getMethod() == "POST") {
            $rules[] = FormRule::new("email")->required()->email()->unique("users", "email");
        } elseif ($req->getMethod() == "PUT") {
            $rules[] = FormRule::new("old_password")->requiredWith("new_password")->null()->string();
            $rules[] = FormRule::new("password")->requiredWith("password")->null()->min(6)->string()->confirmed();
        }

        return $rules;
    }

    public function postProcess(array $in): array
    {
        if (isset($in["password"])) {
            $hash = new PasswordHash(8, false);
            $in['password'] = $hash->HashPassword($in['password']);

            //$in['password'] = Hash::make($in['password']);
        } else {
            $in["password"] = "";
        }

        if (isset($in['new_password'])) {
            $in['new_password'] = $hash->HashPassword($in['new_password']);
        }

        $permission = 0;
        foreach ($in['permissions'] as $perm) {
            $permission |= $perm;
        }
        $in['permissions'] = $permission;

        return $in;
    }
}
