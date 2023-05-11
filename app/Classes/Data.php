<?php

namespace App\Classes;

class Data
{
  // Singleton
    private static $instance;
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

    private array $data;
    private array $fillable;

    public function title($title): void
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

    public function set($key, $value): void
    {
        $this->data[$key] = $value;
    }
}
