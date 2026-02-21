<?php

declare(strict_types=1);

namespace App\Modules\Bank\Application\UseCases;

use App\Modules\Bank\Application\Contracts\ListBanksInterface;
use App\Modules\Bank\Domain\Contracts\BankRepositoryInterface;

final class ListBanks implements ListBanksInterface
{
    private BankRepositoryInterface $repository;

    public function __construct(BankRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute(?int $organizationId = null): array
    {
        if ($organizationId === null) {
            return [];
        }

        return $this->repository->allByOrganization($organizationId);
    }
}
