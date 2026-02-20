<?php

namespace App\Modules\MonthlyFinancialControl\Domain\Contracts;

use App\Modules\MonthlyFinancialControl\Domain\Entities\MonthlyFinancialControl;

interface MonthlyFinancialControlRepositoryInterface
{
    public function findById(int $id): ?MonthlyFinancialControl;
    public function listByOrganization(int $organizationId): array;
    public function save(MonthlyFinancialControl $mfc): MonthlyFinancialControl;
    public function delete(MonthlyFinancialControl $mfc): void;
}
