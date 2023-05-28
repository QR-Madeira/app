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

final class Locations extends FormValidator
{
    public function getRules(Request $req): array
    {
        return [
            FormRule::new("icon")->required()->string(),
            FormRule::new("name")->required()->string()->minmax(3, 80),
            FormRule::new("lat")->required(),
            FormRule::new("lon")->required(),
            FormRule::new("phone_country")
                ->requiredWith("phone")
                ->null()
                ->integer(),
            FormRule::new("phone")
                ->requiredWith("phone_country")
                ->null()
                ->integer()
                ->minmaxDigits(1, 14),
        ];
    }

    public function postProcess(array $in): array
    {
        return $in;
    }
}
