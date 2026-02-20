<?php

namespace App\Modules\Bank\Domain\Contracts;

use App\Modules\Bank\Domain\Entities\Bank;

interface BankRepositoryInterface
{
    public function findById(int $id): ?Bank;
    public function listByOrganization(int $organizationId): array;
    public function save(Bank $bank): Bank;
    public function delete(Bank $bank): void;
}
