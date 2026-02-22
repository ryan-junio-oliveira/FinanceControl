<?php

namespace App\Modules\Bank\Domain\Entities;

use App\Modules\Bank\Domain\ValueObjects\BankName;

final class Bank
{
    private int $id;
    private BankName $name;

    public function __construct(int $id, BankName $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    public function id(): int
    {
        return $this->id;
    }

    public function name(): BankName
    {
        return $this->name;
    }
}
