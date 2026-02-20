<?php

namespace App\Modules\Expense\Domain\Entities;

use DateTime;

final class Expense
{
    private int $id;
    private float $amount;
    private DateTime $transactionDate;
    private ?int $categoryId;
    private int $organizationId;

    public function __construct(
        int $id,
        float $amount,
        DateTime $transactionDate,
        ?int $categoryId,
        int $organizationId
    ) {
        $this->id = $id;
        $this->amount = $amount;
        $this->transactionDate = $transactionDate;
        $this->categoryId = $categoryId;
        $this->organizationId = $organizationId;
    }

    public function id(): int
    {
        return $this->id;
    }

    public function amount(): float
    {
        return $this->amount;
    }

    public function transactionDate(): DateTime
    {
        return $this->transactionDate;
    }

    public function categoryId(): ?int
    {
        return $this->categoryId;
    }

    public function organizationId(): int
    {
        return $this->organizationId;
    }
}
