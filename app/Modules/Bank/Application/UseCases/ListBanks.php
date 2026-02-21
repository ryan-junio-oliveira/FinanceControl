<?php

namespace App\Modules\Bank\Application\UseCases;

use App\Modules\Bank\Domain\Contracts\BankRepositoryInterface;

final class ListBanks
{
    private BankRepositoryInterface $repository;

    public function __construct(BankRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute(): array
    {
        return $this->repository->all();
    }
}
