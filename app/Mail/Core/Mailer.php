<?php

/**
 * @package App\\Mail\\Core
 * @author João Augusto Costa Branco Marado Torres <torres.dev@disroot.org>
 * @copyright Copyright (C) 2023  Danilo Kymhyr, João Torres, Leonardo Abreu de Paulo
 */

declare(encoding="UTF-8");
declare(strict_types=1);

namespace App\Mail\Core;

use Psr\Http\Message\UriInterface;
use Symfony\Component\Mailer\Mailer as Sender;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;
use TorresDeveloper\HTTPMessage\URI;

final class Mailer
{
    public MailerInterface $mailer;
    public UriInterface $dsn;

    public function __construct(?string $dsn = null)
    {
        $dsn ??= env("MAILER_DSN");
        $this->dsn = new URI($dsn);

        $this->mailer = new Sender(Transport::fromDsn($dsn));
    }

    public static function send(Email $email): void
    {
        return (new static())->send($email);
    }

    public function sendEmail(EmailCreator $email): void
    {
        return $this->mailer->send($email->genEmail(new Email(), $this->getAddress()));
    }

    private function getAddress(): ?Address
    {
        $email = explode(":", $this->dsn->getUserInfo())[0] ?? null;

        if ($email === null) {
            return null;
        }

        return new Address($email, (env("APP_NAME") ?? "QR-Madeira"));
    }
}
