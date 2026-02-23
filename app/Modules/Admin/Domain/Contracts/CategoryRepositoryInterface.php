<?php

namespace App\Modules\Admin\Domain\Contracts;

use App\Modules\Admin\Domain\Entities\Category;

interface CategoryRepositoryInterface
{
    /** @return Category[] */
    public function all(?int $organizationId = null): array;
    public function findById(int $id): ?Category;
    public function save(Category $category): Category;
    public function delete(Category $category): void;
}
