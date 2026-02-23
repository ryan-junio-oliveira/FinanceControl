<?php

namespace App\Modules\Admin\Application\UseCases;

use App\Modules\Admin\Application\Contracts\ManageCategoryInterface;
use App\Modules\Admin\Domain\Contracts\CategoryRepositoryInterface;
use App\Modules\Admin\Domain\Entities\Category;

class ManageCategory implements ManageCategoryInterface
{
    private CategoryRepositoryInterface $repo;

    public function __construct(CategoryRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    public function create(string $name, string $type, int $organizationId): Category
    {
        return $this->repo->save(new Category(0, $name, $type, $organizationId));
    }

    public function update(int $id, string $name, string $type, int $organizationId): Category
    {
        return $this->repo->save(new Category($id, $name, $type, $organizationId));
    }

    public function delete(int $id): void
    {
        $existing = $this->repo->findById($id);
        if ($existing) {
            $this->repo->delete($existing);
        }
    }
}
