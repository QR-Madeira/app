<?php

namespace App\Classes;

class Data
{
  // Singleton
    private static $instance;

    private array $data;
    private array $fillable;

    public static function getInstance(): static
    {
      if (!isset(self::$instance)) {
        self::$instance = new static();
      }

      return self::$instance;
    }

    private function __construct()
    {
      $this->format();
    }

    public function title(string $title): void
    {
        $this->fillable['title'] = $title;
    }

    public function format(): void
    {
        $this->data = [];
        $this->fillable = [];
    }

    public function get(): array
    {
        $data = $this->data;
        foreach ($this->fillable as $key => $value) {
            $data[$key] = $value;
        }

        return $data;
    }

    public function set(string $key, mixed $value): void
    {
        $this->data[$key] = $value;
    }
}
