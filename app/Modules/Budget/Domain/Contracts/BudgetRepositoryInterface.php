<?php

namespace App\Modules\Budget\Domain\Contracts;

use App\Modules\Budget\Domain\Entities\Budget;

interface BudgetRepositoryInterface
{
    public function findById(int $id): ?Budget;
    public function listByOrganization(int $organizationId): array;
    public function save(Budget $budget): Budget;
    public function delete(Budget $budget): void;

    /**
     * Calculate total spent amount for the given budget context.
     */
    public function calculateSpent(Budget $budget): float;
} 
