<?php

namespace App\Modules\Recipe\Application\UseCases;

use App\Modules\Recipe\Domain\Contracts\RecipeRepositoryInterface;

final class ListRecipes
{
    private RecipeRepositoryInterface $repository;

    public function __construct(RecipeRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute(int $organizationId): array
    {
        return $this->repository->listByOrganization($organizationId);
    }
}
