<?php

/**
 * @package App\\Mail\\Core
 * @author João Augusto Costa Branco Marado Torres <torres.dev@disroot.org>
 * @copyright Copyright (C) 2023  Danilo Kymhyr, João Torres, Leonardo Abreu de Paulo
 */

declare(encoding="UTF-8");
declare(strict_types=1);

namespace App\Mail\Core;

use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;

interface EmailCreator
{
    public function genEmail(Email $email, Address $address): Email;
}
