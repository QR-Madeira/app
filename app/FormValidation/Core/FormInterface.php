<?php

/**
 * @package App\\FormValidation\\Core
 * @author João Augusto Costa Branco Marado Torres <torres.dev@disroot.org>
 * @copyright Copyright (C) 2023  Danilo Kymhyr, João Torres, Leonardo Abreu de Paulo
 */

declare(encoding="UTF-8");
declare(strict_types=1);

namespace App\FormValidation\Core;

use Illuminate\Http\Request;

interface FormInterface
{
    public function getRules(Request $req): array;
    public function postProcess(array $in): array;
}
