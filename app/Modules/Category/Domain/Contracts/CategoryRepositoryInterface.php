<?php

namespace App\Modules\Category\Domain\Contracts;

use App\Modules\Category\Domain\Entities\Category;

interface CategoryRepositoryInterface
{
    public function findById(int $id): ?Category;
    public function listByOrganization(int $organizationId): array;
    public function save(Category $category): Category;
    public function delete(Category $category): void;
}
