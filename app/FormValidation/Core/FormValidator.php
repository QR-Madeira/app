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
use Illuminate\Support\Facades\Validator;

abstract class FormValidator implements FormInterface
{
    private Request $validator;
    private array $rules;

    final public function __construct(Request $validator, bool $init = false)
    {
        $this->validator = $validator;
        $this->rules = [];

        if ($init) {
            $this->init();
        }
    }

    final public static function verify(Request $req): array
    {
        return (new static($req, true))->validate();
    }

    final public function init(): static
    {
        $rules = $this->getRules();
        foreach ($rules as $i) {
            if (!($i instanceof FormRule)) {
                throw new \RuntimeException("invalid form rule on " . static::class . "::getRules().");
            }

            $this->setRule($i);
        }

        return $this;
    }

    final public function validate(): array
    {
        $validator = Validator::make($this->validator->all(), $this->rules);
        if ($validator->fails()) {
            foreach ($validator->getData() as $k => $v) {
                if (!str_starts_with($k, "_")) {
                    $this->validator->flash($k, $v);
                }
            }
            throw new FormValidationException(implode(". ", [...$validator->errors()->all()]));
        }

        return $validator->validated();
    }

    final public function setValidator(Request $validator): static
    {
        $this->validator = $validator;

        return $this;
    }

    final public function setRule(FormRule ...$rules): static
    {
        foreach ($rules as $i) {
            $this->rules[$i->getField()] = $i->getRules();
        }

        return $this;
    }

    protected function humanize(string $field): string
    {
        return ucwords(strtr($field, "-", " "));
    }
}
