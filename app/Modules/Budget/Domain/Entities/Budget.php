<?php

namespace App\Modules\Budget\Domain\Entities;

use DateTime;

final class Budget
{
    private int $id;
    private string $name;
    private float $amount;
    private DateTime $startDate;
    private DateTime $endDate;
    private ?int $categoryId;
    private bool $isActive;
    private int $organizationId;

    public function __construct(
        int $id,
        string $name,
        float $amount,
        DateTime $startDate,
        DateTime $endDate,
        ?int $categoryId,
        bool $isActive,
        int $organizationId
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->amount = $amount;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->categoryId = $categoryId;
        $this->isActive = $isActive;
        $this->organizationId = $organizationId;
    }

    // getters and any business methods
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

    public function startDate(): DateTime
    {
        return $this->startDate;
    }

    public function endDate(): DateTime
    {
        return $this->endDate;
    }

    public function categoryId(): ?int
    {
        return $this->categoryId;
    }

    public function isActive(): bool
    {
        return $this->isActive;
    }

    public function organizationId(): int
    {
        return $this->organizationId;
    }

    public function spent(): float
    {
        // placeholder; actual calc happens in repository or domain service
        return 0.0;
    }

    public function progressPercent(): float
    {
        if ($this->amount === 0) {
            return 0.0;
        }

        return min(100.0, round(($this->spent() / $this->amount) * 100, 2));
    }
}
