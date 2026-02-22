<?php

namespace App\Modules\Investment\Domain\Entities;

use DateTime;

final class Investment
{
    private int $id;
    private string $name;
    private float $amount;
    private DateTime $transactionDate;
    private bool $fixed;
    private int $organizationId;

    public function __construct(
        int $id,
        string $name,
        float $amount,
        DateTime $transactionDate,
        bool $fixed,
        int $organizationId
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->amount = $amount;
        $this->transactionDate = $transactionDate;
        $this->fixed = $fixed;
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

    public function amount(): float
    {
        return $this->amount;
    }

    public function transactionDate(): DateTime
    {
        return $this->transactionDate;
    }

    public function fixed(): bool
    {
        return $this->fixed;
    }

    public function organizationId(): int
    {
        return $this->organizationId;
    }
}
