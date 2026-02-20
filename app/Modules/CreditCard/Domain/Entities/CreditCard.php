<?php

namespace App\Modules\CreditCard\Domain\Entities;

final class CreditCard
{
    private int $id;
    private string $name;
    private int $organizationId;
    private int $bankId;
    private ?string $bankName;
    private float $statementAmount;
    private ?float $limit;
    private ?int $closingDay;
    private ?int $dueDay;
    private bool $isActive;
    private ?string $color;

    public function __construct(
        int $id,
        string $name,
        int $organizationId,
        int $bankId,
        ?string $bankName,
        float $statementAmount,
        ?float $limit,
        ?int $closingDay,
        ?int $dueDay,
        bool $isActive,
        ?string $color
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->organizationId = $organizationId;
        $this->bankId = $bankId;
        $this->bankName = $bankName;
        $this->statementAmount = $statementAmount;
        $this->limit = $limit;
        $this->closingDay = $closingDay;
        $this->dueDay = $dueDay;
        $this->isActive = $isActive;
        $this->color = $color;
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

    public function bankId(): int
    {
        return $this->bankId;
    }

    public function bankName(): ?string
    {
        return $this->bankName;
    }

    public function statementAmount(): float
    {
        return $this->statementAmount;
    }

    public function limit(): ?float
    {
        return $this->limit;
    }

    public function closingDay(): ?int
    {
        return $this->closingDay;
    }

    public function dueDay(): ?int
    {
        return $this->dueDay;
    }

    public function isActive(): bool
    {
        return $this->isActive;
    }

    public function color(): ?string
    {
        return $this->color;
    }
}
