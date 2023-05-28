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
use App\FormValidation\Core\FormValidationException;
use App\FormValidation\Core\FormValidator;
use Illuminate\Http\Request;
use Psr\Http\Message\UriInterface;
use TorresDeveloper\HTTPMessage\URI;

final class Socials extends FormValidator
{
    private const DEFAULT_ICO = "default_web_icon.svg";
    private const HOST_ICO = [
        "www.facebook.com" => "facebook.svg",
        "facebook.com" => "facebook.svg",
        "www.github.com" => "github-mark.svg",
        "github.com" => "github-mark.svg",
        "www.linkedin.com" => "linkedin.svg",
        "linkedin.com" => "linkedin.svg",
        "www.tiktok.com" => "tiktok.svg",
        "tiktok.com" => "tiktok.svg",
        "www.twitch.tv" => "twitch.svg",
        "twitch.tv" => "twitch.svg",
        "www.twitter.com" => "twitter.svg",
        "twitter.com" => "twitter.svg",
        "www.youtube.com" => "youtube.svg",
        "youtube.com" => "youtube.svg",
    ];

    public function getRules(Request $req): array
    {
        return [
            FormRule::new("description")->required()->string()->max(140),
            FormRule::new("uri")->required()->string(),
        ];
    }

    public function postProcess(array $in): array
    {
        try {
            $uri = new URI($in["uri"]);
        } catch (\DomainException $e) {
            throw new FormValidationException(
                $e->getMessage(),
                $e->getCode(),
                $e
            );
        }

        $in["ico"] = $this->icoForHost($uri);

        return $in;
    }

    private function icoForHost(UriInterface $uri): string
    {
        return self::HOST_ICO[$uri->getHost()] ?? self::DEFAULT_ICO;
    }
}
