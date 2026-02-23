<?php

namespace App\Modules\Admin\Domain\Entities;

final class Bank
{
    private int $id;
    private string $name;

    public function __construct(int $id, string $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    public function id(): int
    {
        return $this->id;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function __get($prop)
    {
        // allow ->id and ->name in views
        if ($prop === 'id') {
            return $this->id();
        }
        if ($prop === 'name') {
            return $this->name();
        }
        return null;
    }
}
