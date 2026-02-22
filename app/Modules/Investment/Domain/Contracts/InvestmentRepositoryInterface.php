<?php

namespace App\Modules\Investment\Domain\Contracts;

use App\Modules\Investment\Domain\Entities\Investment;

interface InvestmentRepositoryInterface
{
    public function findById(int $id): ?Investment;
    public function listByOrganization(int $organizationId): array;
    public function save(Investment $investment): Investment;
    public function delete(Investment $investment): void;
}
