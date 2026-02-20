<?php

namespace App\Modules\Organization\Domain\Entities;

final class Organization
{
    private int $id;
    private string $name;
    private bool $archived;

    public function __construct(int $id, string $name, bool $archived)
    {
        $this->id = $id;
        $this->name = $name;
        $this->archived = $archived;
    }

    public function id(): int
    {
        return $this->id;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function archived(): bool
    {
        return $this->archived;
    }
}
