<?php

namespace App\Modules\Category\Application\UseCases;

use App\Modules\Category\Domain\Contracts\CategoryRepositoryInterface;

final class ListCategories
{
    private CategoryRepositoryInterface $repository;

    public function __construct(CategoryRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute(int $organizationId): array
    {
        return $this->repository->listByOrganization($organizationId);
    }
}
