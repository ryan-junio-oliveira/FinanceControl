<?php

namespace App\Modules\Admin\Application\UseCases;

use App\Modules\Admin\Application\Contracts\ListCategoriesInterface;
use App\Modules\Admin\Domain\Contracts\CategoryRepositoryInterface;

class ListCategories implements ListCategoriesInterface
{
    private CategoryRepositoryInterface $repo;

    public function __construct(CategoryRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    public function execute(?int $organizationId = null): array
    {
        return $this->repo->all($organizationId);
    }
}
