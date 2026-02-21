<?php

declare(strict_types=1);

namespace App\Modules\Bank\Domain\ValueObjects;

use InvalidArgumentException;

final class BankName
{
    private string $value;

    public function __construct(string $value)
    {
        $trimmed = trim($value);
        if ($trimmed === '') {
            throw new InvalidArgumentException('Bank name cannot be empty.');
        }

        $this->value = $trimmed;
    }

    public function __toString(): string
    {
        return $this->value;
    }

    public function equals(BankName $other): bool
    {
        return strtolower($this->value) === strtolower($other->value);
    }
}
