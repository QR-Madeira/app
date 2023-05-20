<?php

/**
 * @package App\\Mail
 * @author João Augusto Costa Branco Marado Torres <torres.dev@disroot.org>
 * @copyright Copyright (C) 2023  Danilo Kymhyr, João Torres, Leonardo Abreu de Paulo
 */

declare(encoding="UTF-8");
declare(strict_types=1);

namespace App\Mail;

use App\Mail\Core\EmailCreator;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\Address;

class Example implements EmailCreator
{
    public function genEmail(Email $email, Address $address): Email
    {
        return $email->from($address)
            ->to(...["al220007@epcc.pt"])
            //->cc("cc@example.com")
            //->bcc("bcc@example.com")
            //->replyTo("fabien@example.com")
            //->priority(Email::PRIORITY_HIGH)
            ->subject("Time for Symfony Mailer!")
            ->text("Sending emails is fun again!")
            ->html("<p>See Twig integration for better HTML integration!</p>");
    }
}
