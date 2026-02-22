<?php

namespace App\Modules\Investment\Application\UseCases;

use App\Modules\Investment\Domain\Contracts\InvestmentRepositoryInterface;

final class ListInvestments
{
    private InvestmentRepositoryInterface $repository;

    public function __construct(InvestmentRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute(int $organizationId): array
    {
        return $this->repository->listByOrganization($organizationId);
    }
}
