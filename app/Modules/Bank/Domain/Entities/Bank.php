<?php

namespace App\Modules\Bank\Domain\Entities;

use App\Modules\Bank\Domain\ValueObjects\BankName;

final class Bank
{
    private int $id;
    private BankName $name;
    private int $organizationId;

    public function __construct(int $id, BankName $name, int $organizationId)
    {
        $this->id = $id;
        $this->name = $name;
        $this->organizationId = $organizationId;
    }

    public function id(): int
    {
        return $this->id;
    }

    public function name(): BankName
    {
        return $this->name;
    }

    public function organizationId(): int
    {
        return $this->organizationId;
    }
}
