<?php

/**
 * @package App\\FormValidation
 * @author João Augusto Costa Branco Marado Torres <torres.dev@disroot.org>
 * @copyright Copyright (C) 2023  Danilo Kymhyr, João Torres, Leonardo Abreu de Paulo
 */

declare(encoding="UTF-8");

declare(strict_types=1);

namespace App\FormValidation;

use App\FormValidation\Core\FormRule;
use App\FormValidation\Core\FormValidator;

final class Locations extends FormValidator
{
    public function getRules(): array
    {
        return [
            FormRule::new("icon")
                ->required()
                ->string(),
            FormRule::new("name")
                ->required()
                ->string()
                ->minmax(3, 80),
            FormRule::new("location")
                ->required()
                ->string()
                ->minmax(3, 80),
            FormRule::new("phone")->null(),
        ];
    }
}
