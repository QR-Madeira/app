<?php

/**
 * @package App\\Mail\\Core
 * @author João Augusto Costa Branco Marado Torres <torres.dev@disroot.org>
 * @copyright Copyright (C) 2023  Danilo Kymhyr, João Torres, Leonardo Abreu de Paulo
 */

declare(encoding="UTF-8");
declare(strict_types=1);

namespace App\Mail\Core;

use Symfony\Component\Mailer\Mailer as Sender;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;

final class Mailer
{
    public MailerInterface $mailer;
    public string $from;

    public function __construct(?string $dsn = null)
    {
        $dsn ??= env("MAILER_DSN");

        $this->from = explode("/", explode(":", $dsn)[1])[2] ?? null;

        $this->mailer = new Sender(Transport::fromDsn($dsn));
    }

    public static function send(EmailCreator $email): void
    {
        $mailer = new static();
        $mailer->sendEmail($email);
    }

    public function sendEmail(EmailCreator $email): void
    {
        $this->mailer->send($email->genEmail(new Email(), $this->getAddress()));
    }

    private function getAddress(): ?Address
    {
        if ($this->from === null) {
            return null;
        }

        return new Address($this->from, (env("APP_NAME") ?? "QR-Madeira"));
    }
}
