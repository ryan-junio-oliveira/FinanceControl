<?php

namespace App\Modules\MonthlyFinancialControl\Domain\Entities;

final class MonthlyFinancialControl
{
    private int $id;
    private string $month;
    private int $organizationId;

    public function __construct(int $id, string $month, int $organizationId)
    {
        $this->id = $id;
        $this->month = $month;
        $this->organizationId = $organizationId;
    }

    public function id(): int
    {
        return $this->id;
    }

    public function month(): string
    {
        return $this->month;
    }

    public function organizationId(): int
    {
        return $this->organizationId;
    }
}
