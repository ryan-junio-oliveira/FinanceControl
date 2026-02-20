<?php

namespace App\Modules\Organization\Application\UseCases;

use App\Modules\Organization\Domain\Contracts\OrganizationRepositoryInterface;

final class ListOrganizations
{
    private OrganizationRepositoryInterface $repository;

    public function __construct(OrganizationRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute(): array
    {
        return $this->repository->listAll();
    }
}
