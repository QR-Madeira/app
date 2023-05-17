<?php

/**
 * @package App\\FormValidation\\Core
 * @author João Augusto Costa Branco Marado Torres <torres.dev@disroot.org>
 * @copyright Copyright (C) 2023  Danilo Kymhyr, João Torres, Leonardo Abreu de Paulo
 */

declare(encoding="UTF-8");
declare(strict_types=1);

namespace App\FormValidation\Core;

final class FormRule
{
    private string $field;
    private array $rules;

    public function __construct(string $field, string ...$rules)
    {
        $this->field = $field;
        $this->rules = $rules;
    }

    public static function new(string $field, string ...$rules): self
    {
        return new self($field, ...$rules);
    }

    public function getField(): string
    {
        return $this->field;
    }
    public function getRules(): string
    {
        return implode("|", $this->rules);
    }

    public function setField(string $field): void
    {
        $this->field = $field;
    }
    public function setRules(string ...$rules): void
    {
        $this->rules = $rules;
    }
    public function appendRules(string ...$rules): void
    {
        foreach ($rules as $i) {
            $this->rules[] = $i;
        }
    }
    public function resetRules(): void
    {
        $this->rules = [];
    }


    public function required(): static
    {
        $this->appendRules("required", "filled", "present");
        return $this;
    }
    public function requiredUnlessNull(string $name): static
    {
        $this->appendRules("required_unless:$name,null");
        return $this;
    }
    public function requiredWith(string ...$names): static
    {
        $this->appendRules("required_with:" . implode(",", $names));
        return $this;
    }
    public function string(): static
    {
        $this->appendRules("string");
        return $this;
    }
    public function integer(): static
    {
        $this->appendRules("integer");
        return $this;
    }
    public function numeric(): static
    {
        $this->appendRules("numeric");
        return $this;
    }
    public function max(int $max): static
    {
        $this->appendRules("max:$max");
        return $this;
    }
    public function min(int $min): static
    {
        $this->appendRules("min:$min");
        return $this;
    }
    public function minmax(int $min, int $max): static
    {
        return $this->min($min)->max($max);
    }
    public function minmaxDigits(int $min, int $max): static
    {
        $this->appendRules("digits_between:$min,$max");
        return $this;
    }
    public function null(): static
    {
        $this->appendRules("nullable");
        return $this;
    }
}
