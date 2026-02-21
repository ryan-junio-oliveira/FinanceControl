<?php

declare(strict_types=1);

namespace App\Contracts;

interface UseCaseInterface
{
    public function execute(): array;
}
