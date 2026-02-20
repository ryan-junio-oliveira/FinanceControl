<?php

namespace App\Modules\CreditCard\Application\Dto;

final class CreditCardDto
{
    public int $id;
    public string $name;
    public ?string $bankName;
    public float $statementAmount;
    public ?float $limit;
    public ?int $closingDay;
    public ?int $dueDay;
    public bool $isActive;
    public ?string $color;

    public function __construct(
        int $id,
        string $name,
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
        $this->bankName = $bankName;
        $this->statementAmount = $statementAmount;
        $this->limit = $limit;
        $this->closingDay = $closingDay;
        $this->dueDay = $dueDay;
        $this->isActive = $isActive;
        $this->color = $color;
    }

    public function name(): string
    {
        return $this->name;
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
