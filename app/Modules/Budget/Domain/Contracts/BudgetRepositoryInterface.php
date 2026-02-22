<?php

namespace App\Modules\Budget\Domain\Contracts;

use App\Modules\Budget\Domain\Entities\Budget;

interface BudgetRepositoryInterface
{
    public function findById(int $id): ?Budget;
    /**
     * Return paginated budgets for an organization.
     *
     * @param int $organizationId
     * @param int $perPage
     * @param int|null $page
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator<\App\Modules\Budget\Domain\Entities\Budget>
     */
    public function listByOrganization(int $organizationId, int $perPage = 20, ?int $page = null);

    public function save(Budget $budget): Budget;
    public function delete(Budget $budget): void;

    /**
     * Calculate total spent amount for the given budget context.
     */
    public function calculateSpent(Budget $budget): float;
} 
