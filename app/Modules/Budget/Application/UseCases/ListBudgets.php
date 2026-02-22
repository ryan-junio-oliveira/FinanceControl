<?php

namespace App\Modules\Budget\Application\UseCases;

use App\Modules\Budget\Domain\Contracts\BudgetRepositoryInterface;

final class ListBudgets
{
    private BudgetRepositoryInterface $repository;

    public function __construct(BudgetRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Execute the list operation and return a paginator of budgets.
     *
     * @param int $organizationId
     * @param int $perPage
     * @param int|null $page
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator<\App\Modules\Budget\Domain\Entities\Budget>
     */
    public function execute(int $organizationId, int $perPage = 20, ?int $page = null)
    {
        return $this->repository->listByOrganization($organizationId, $perPage, $page);
    }
}
