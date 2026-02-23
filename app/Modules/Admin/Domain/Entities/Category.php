<?php

namespace App\Modules\Admin\Domain\Entities;

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

    public function __get($prop)
    {
        switch ($prop) {
            case 'id':
                return $this->id();
            case 'name':
                return $this->name();
            case 'type':
                return $this->type();
            case 'organization_id':
                return $this->organizationId();
        }
        return null;
    }
}
