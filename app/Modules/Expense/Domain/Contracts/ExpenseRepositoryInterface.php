<?php

namespace App\Modules\Expense\Domain\Contracts;

use App\Modules\Expense\Domain\Entities\Expense;

interface ExpenseRepositoryInterface
{
    public function findById(int $id): ?Expense;
    public function listByOrganization(int $organizationId): array;
    public function save(Expense $expense): Expense;
    public function delete(Expense $expense): void;
}
