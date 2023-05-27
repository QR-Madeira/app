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

final class Log extends FormValidator
{
    public function getRules(Request $req): array
    {
        return [
            FormRule::new("email")->required()->email(),
            FormRule::new("password")->required(),
        ];
    }

    public function postProcess(array $in): array
    {
        return $in;
    }
}
