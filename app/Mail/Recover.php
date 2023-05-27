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
use App\Models\User;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\Address;

final class Recover implements EmailCreator
{
    private const VIEW = "emails/recover";

    private User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function genEmail(Email $email, Address $address): Email
    {
        $code = $this->generateVerificationCode();
        return $email->from($address)
            ->to($this->user->email)
            ->subject("New Account")
            ->html(view(static::VIEW, [
                "user" => $this->user,
                "app" => env("APP_NAME"),
                "url" => env("APP_URL"),
                "login" => route("login"),
                "verify_url" => route("verify")
                    . "?email="
                    . $this->user->email
                    . "&code=$code",
                "code" => $code,
            ])->render());
    }

    private function generateVerificationCode(): string
    {
        $code = $this->rndStr();

        $this->user->verification_code = $code;
        $this->user->save();

        return $code;
    }

    private function rndStr(int $length = 8)
    {
        $chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $str = "";

        for ($i = 0; $i < $length; $i++) {
            $str .= $chars[random_int(0, strlen($chars) - 1)];
        }

        return $str;
    }
}
