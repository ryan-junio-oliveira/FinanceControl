<?php

namespace App\Modules\CreditCard\Domain\Contracts;

use App\Modules\CreditCard\Domain\Entities\CreditCard;

interface CreditCardRepositoryInterface
{
    public function findById(int $id): ?CreditCard;
    public function listByOrganization(int $organizationId): array;
    public function save(CreditCard $card): CreditCard;
    public function delete(CreditCard $card): void;
}
