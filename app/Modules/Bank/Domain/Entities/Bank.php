<?php

namespace App\Modules\Bank\Domain\Entities;

final class Bank
{
    private int $id;
    private string $name;
    private int $organizationId;

    public function __construct(int $id, string $name, int $organizationId)
    {
        $this->id = $id;
        $this->name = $name;
        $this->organizationId = $organizationId;
    }

    public function id(): int
    {
        return $this->id;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function organizationId(): int
    {
        return $this->organizationId;
    }
}
