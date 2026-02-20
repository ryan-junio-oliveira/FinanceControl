<?php

namespace App\Modules\Category\Domain\Entities;

final class Category
{
    private int $id;
    private string $name;
    private string $type;
    private int $organizationId;

    public function __construct(int $id, string $name, string $type, int $organizationId)
    {
        $this->id = $id;
        $this->name = $name;
        $this->type = $type;
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

    public function type(): string
    {
        return $this->type;
    }

    public function organizationId(): int
    {
        return $this->organizationId;
    }
}
